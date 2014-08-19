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
 * @author CMSWorks Team
 * @copyright (c) CMSWorks Team 2010-2014
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

// Environment setup
define('COT_CWSENDER', TRUE);
$env['location'] = 'cwsender';

require_once cot_incfile('cwsender', 'module');

if(empty($m)){
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
}
elseif($m == 'subscribe')
{
	$id = cot_import('id', 'G', 'INT');
	$status = cot_import('status', 'G', 'ALP');
	
	$subs = $db->query("SELECT * FROM $db_cwsender_lists WHERE list_id=".$id." AND list_type='subs'")->fetch();
	cot_block($subs);

	
	// Подписка пользователя на рассылку
	if($a == 'send')
	{
		$rrec['rec_listid'] = $id;
		$rrec['rec_email'] = cot_import('remail', 'P', 'TXT', 64, TRUE);
		$rrec['rec_name'] = cot_import('rname', 'P', 'TXT');

		$emailexists = (bool)$db->query("SELECT rec_id FROM $db_cwsender_lists_recipients WHERE rec_email = ? LIMIT 1", array($rrec['rec_email']))->fetch();
		
		cot_check(empty($rrec['rec_email']), 'cwsender_subscribe_error_email_empty', 'remail');
		cot_check(!cot_check_email($rrec['rec_email']), 'cwsender_subscribe_error_email_wrong', 'remail');
		cot_check($emailexists, 'cwsender_subscribe_error_email_exists', 'remail');
			
		if (!cot_error_found()){
			$db->insert($db_cwsender_lists_recipients, $rrec);
			$status = 'sent';
		}
		cot_redirect(cot_url('cwsender', 'm=subscribe&id='.$id.'&status='.$status, '', true));
	}
	
	require_once $cfg['system_dir'].'/header.php';
	$t = new XTemplate(cot_tplfile(array('cwsender', $id), 'module'));
	
	cot_display_messages($t, 'MAIN.SUBSCRIBE');
	
	$t->assign(array(
		'SUBS_ID' => $subs['list_id'],
		'SUBS_TITLE' => $subs['list_title'],
	));
	$t->parse('MAIN.SUBSCRIBE');
	
	$t->parse('MAIN');
	$t->out('MAIN');

	require_once $cfg['system_dir'].'/footer.php';
}