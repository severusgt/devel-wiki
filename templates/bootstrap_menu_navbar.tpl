<ul class="{if $bs_menu_class}{$bs_menu_class}{else}nav navbar-nav{/if}">
	{foreach from=$list item=item}
		{if not empty($item.children)}
			<li class="dropdown{if $item.selected|default:null} active{/if} {$item.class|escape}">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					{tr}{$item.name}{/tr}
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					{foreach from=$item.children item=sub}
						<li class="{$sub.class|escape}{if $sub.selected|default:null} active{/if}"><a href="{$sub.sefurl|escape}">{tr}{$sub.name}{/tr}</a></li>
					{/foreach}
				</ul>
			</li>
		{else}
			<li class="{$item.class|escape}{if $item.selected|default:null} active{/if}"><a href="{$item.sefurl|escape}">{tr}{$item.name}{/tr}</a></li>
		{/if}
	{/foreach}
</ul>
