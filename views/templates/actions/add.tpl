<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css">
<style>.bootstrap label { width: auto; }</style>
<div class="bootstrap">
    {if isset($error)}
        <p class="alert alert-danger">{$error}</p>
    {/if}    
    <div class="col-md-9">
        <h4><i class="fa fa-pencil"></i> Add an Advisory</h4>
        <div class="panel">
            <form action="{$action}" class="form" method="POST">
                <div class="form-group">
                    <label for="title">Title <sup class="text text-danger">*</sup></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter the advisory title" autofocus />
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="10" placeholder="Enter your advisory description"></textarea>
                </div>
                <div class="form-group">
                    <label for="active">Status</label>
                    <select name="active" id="active" class="form-control">
                        <option value="1">Enable</option>
                        <option value="0" selected="selected">Disable</option>
                    </select>
                </div>
                <div class="input-group">
                    <a href="{$url}" class="btn btn-default"> <i class="fa fa-arrow-left"></i> Go back</a> &nbsp;
                    <button type="submit" name="action_add" class="btn btn-danger"> <i class="fa fa-check"></i> Add the advisory</button>
                </div>
            </form>
        </div>
    </div>
</div>