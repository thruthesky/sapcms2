$ = jQuery;
$(function(){
	$("body").on("click",".category-setting .add-child", categoryAddChild );
});

function categoryAddChild(){
	$this = $(this);	
	if( $this.parent().find("form.add-child-form").length ) return;
	$("form.add-child-form").remove();

	parent_idx = $this.parent().attr('idx');
	description = $this.parent().attr('description');
	
	$form = getChildForm( parent_idx, description );
	$this.after( $form );
	
	$this.parent().find("input[name='name']").focus();
}

function getChildForm( parent_idx, description ){	
	return	"<form class='add-child-form' action='/admin/category/setting/submit' method='post'>" +
			"<input type='hidden' name='idx_parent' value='" + parent_idx + "'>" +
			"<input type='text' name='name' placeholder='Input name'>" +			
			"<input class='admin-button' type='submit'>" +
			"</form>";
}

function confirmCategoryDelete( e ){
    return confirm( "Are you sure you want to delete - "+e+"?" );
}