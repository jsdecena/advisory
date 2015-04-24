{if isset($advisory) || !empty($advisory)}
	<div id="top-advisory">
		<div class="container">
			<div class="advisory-content">
				{$advisory|truncate:50:'...':true|escape:'html':'UTF-8'} <a class="fancy" href="{$url}">Read more</a> <a href="javascript: void(0)" id="btn-close-advisory"> <i class="fa fa-times"></i> <span class="hidden">Close</span></a>
			</div>							
		</div>
	</div>
{/if}