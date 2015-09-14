$ = jQuery;
$(function(){
	$("body").on("click",".category-setting .add-child", categoryAddChild );
});

function categoryAddChild(){
	$this = $(this);
	if( $this.parent().find("form.add-child-form").length ) return;

	parent_idx = $this.parent().attr('idx');
	description = $this.parent().attr('description');
	
	$form = getChildForm( parent_idx, description );
	$this.after( $form );
}

function getChildForm( parent_idx, description ){	
	return	"<form class='add-child-form' action='/admin/category/setting/submit' method='post'>" +
			"<input type='hidden' name='idx_parent' value='" + parent_idx + "'>" +
			"<input type='text' name='name' placeholder='Input name'>" +			
			"<input type='submit'>" +
			"</form>";
}