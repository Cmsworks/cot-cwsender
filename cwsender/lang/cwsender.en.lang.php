<?php

defined('COT_CODE') or die('Wrong URL.');

$L['info_desc'] = 'Менеджер рассылок';

$L['cfg_limittosend'] = 'Количество отправленных сообщений за один цикл';

$L['cwsender_lists_title'] = 'Списки получателей';
$L['cwsender_lists_add_title'] = 'Создание списка рассылки';
$L['cwsender_lists_add_button'] = 'Создать список';
$L['cwsender_lists_form_title'] = 'Заголовок';
$L['cwsender_lists_form_recipients'] = 'Получатели';
$L['cwsender_lists_form_type_text_title'] = 'Текстовый список';
$L['cwsender_lists_form_type_text_desc'] = 'Формат списка: E-mail,Имя (каждый получатель в отдельной строчке, имя указывать не обязательно)';
$L['cwsender_lists_form_type_groups_title'] = 'Группы пользователей';
$L['cwsender_lists_form_type_groups_desc'] = 'Выберите группы, пользователям которых будет осуществляться рассылка по этому списку.';
$L['cwsender_lists_form_type_mysql_title'] = 'Mysql-запрос';
$L['cwsender_lists_form_type_mysql_desc'] = 'Внимание! Только для специалистов. Будьте внимательны при составлении запроса.<br/>Пример запроса: select name as user_name, email as user_email from cot_users where user_maingrp=4</p>';
$L['cwsender_lists_form_type_subs_title'] = 'Подписка';
$L['cwsender_lists_form_type_subs_desc'] = 'Опция в разработке!';

$L['cwsender_letters_title'] = 'Рассылки';
$L['cwsender_letters_add_title'] = 'Создание сообщения для рассылки';
$L['cwsender_letters_add_button'] = 'Создать соощение';
$L['cwsender_letters_status_ready'] = 'Готово к рассылке';
$L['cwsender_letters_status_process'] = 'Рассылается...';
$L['cwsender_letters_status_sent'] = 'Рассылка завершена';
$L['cwsender_letters_form_title'] = 'Заголовок';
$L['cwsender_letters_form_text'] = 'Текст';
$L['cwsender_letters_form_list'] = 'Список рассылки';

$L['cwsender_error_type_text_empty'] = 'Не заполнен список получателей';
$L['cwsender_error_type_groups_empty'] = 'Не выбраны группы получателей';
$L['cwsender_error_type_mysql_empty'] = 'Не составлен mysql-запрос';

$L['cwsender_error_letter_title_empty'] = 'Не указан заголовок  рассылки';
$L['cwsender_error_letter_text_empty'] = 'Не указан текст рассылки';
$L['cwsender_error_letter_list_notselect'] = 'Не выбран список рассылки';
