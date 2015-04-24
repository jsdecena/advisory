<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css">
<div class="bootstrap">
    <div class="col-md-9">
        <p class="alert alert-warning">Reminder: You can set only 1 active advisory at a time.</p>
        {if Tools::getValue('success')}
            <p class="alert alert-success">{Tools::getValue('message')}</p>
        {/if}
        <div class="panel">
            <a href="{$url}&page=add" class="btn btn-primary pull-right">Add new advisory</a>
            {if !empty($records)}<br /> <br />
                <table class="table">
                    <thead>
                        <th class="col-md-3">#</th>
                        <th class="col-md-3">Title</th>
                        <th class="col-md-3">Description</th>
                        <th class="col-md-1">Active</th>
                        <th class="col-md-2">Actions</th>
                    </thead>
                    <tbody>
                        {foreach from=$records item=record}
                            <tr>
                                <td>{$record.id}</td>
                                <td>{$record.title|truncate:30:'...':true|escape:'html':'UTF-8'}</td>
                                <td>{$record.description|truncate:80:'...':true|escape:'html':'UTF-8'}</td>
                                <td>
                                    {if $record.active == 1}
                                        <a href="javascript:void(0)" class="btn btn-success"> <i class="fa fa-check"></i></a>
                                    {else}
                                        <a href="javascript:void(0)" class="btn btn-danger"> <i class="fa fa-times"></i></a>
                                    {/if}
                                </td>
                                <td class="btn-group-action">
                                    <a href="{$url}&page=update&id={$record.id}" class="btn btn-default"> <i class="fa fa-pencil"></i> Edit</a>
                                    <a href="{$url}&page=delete&id={$record.id}" class="btn btn-danger" onClick="return confirm('Are you sure you want to delete this?')"> <i class="fa fa-times"></i> Delete</a>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            {else}
                <p class="alert alert-dangeer"> No results found.</p>
            {/if}
        </div>
    </div>
</div>