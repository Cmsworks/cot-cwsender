<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=module
[END_COT_EXT]
==================== */

/**
 * Cwsender module
 *
 * @package page
 * @version 1.0.0
 * @author Cotonti Team
 * @copyright Copyright (c) Cotonti Team 2008-2013
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Environment setup
define('COT_CWSENDER', TRUE);
$env['location'] = 'cwsender';

require_once cot_incfile('cwsender', 'module');

// Этот скрипт будет запускаться планировщиком для осуществляения рассылки сообщений, которые добавлены в очередь для рассылки.

// Цикл по очереди
$sql_letters = $db->query("SELECT letter_id FROM $db_cwsender_letters WHERE letter_status='process'");
while($lid = $sql_letters->fetchColumn())
{
	// Получаем список получателей
	$letter = cwsender_getletterinfobyid($lid);
	
	// Если письмо в html формате
	if($letter['type'] == 'html')
	{
		$html = true;
	}
			
	if(is_array($letter['recipients']))
	{
		$sentcount = 0;
		foreach ($letter['recipients'] as $i => $recipient)
		{
			$sentcount++;
			
			cot_mail($recipient['email'], $letter['title'], cot_rc($letter['text'], array('username' => $recipient['name'])), '', false, null, $html);
			$db->update($db_cwsender_letters_recipients, array('rec_sent' => 1), "rec_id=" . $recipient['id']);
			
			// Если всем получателям отправлено сообщение, то изменяем статус этой рассылки на done
			if($sentcount == count($letter['recipients'])) 
			{
				$options['status'] = 'done';
				cwsender_update_letter($lid, $options);
				
				break;
			}

			// Если лимит на одну операцию рассылки исчерпан, то останавливаем цикл по этой рассылке.
			if($sentcount == $cfg['cwsender']['limittosend'])
			{
				break;
			}
		}
	}
}