{* $Id: newsletter_articleclip.tpl 66259 2018-05-03 22:30:26Z jyhem $ *}

<!-- {tr}Start of article{/tr} -->
<div class="articleclip_single">
{if $nlArticleClipTitle}<h3 class="articleclip_title"><a href="{$base_url}{$nlArticleClipId|sefurl:'article'}">{$prefs.mail_template_custom_text}{$nlArticleClipTitle|escape}</a></h3>{/if}
{if $nlArticleClipSubtitle}<h5 class="articleclip_subtitle">{$nlArticleClipSubtitle|escape}</h5>{/if}
{if $nlArticleClipPublishDate}<span class="articleclip_date">{tr}Published:{/tr} {$nlArticleClipPublishDate|tiki_short_datetime:"":"n"}</span>{/if}
{if $nlArticleClipAuthorName}<span class="articleclip_author">{tr}By:{/tr} {$nlArticleClipAuthorName|username}</span>{/if}
{if $nlArticleClipParsedheading}<div class="articleclip_body">{$nlArticleClipParsedheading}</div>{/if}
</div>
