{if !empty($records)}
	{foreach from=$records item=record}
		<h3>{$record.title}</h3>
		<p>{$record.description}</p>
	{/foreach}
{else}
	<p class="alert alert-danger">No results found.</p>
{/if}