{* $Id: tracker_changed_notification_subject.tpl 66337 2018-05-11 20:20:40Z luciash $ *}{$prefs.mail_template_custom_text}"{tr}{$mail_trackerName}{/tr}" {tr}item{/tr} "{$mail_item_desc}" {if $mail_action eq 'deleted'}{tr}was deleted at{/tr}{else}{tr}was modified at{/tr}{/if} {$server_name} {tr}by{/tr} "{if not empty($user)}{$user|username}{else}{tr}Anonymous{/tr}{/if}"
