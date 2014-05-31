$(document).ready(function(){
	
	$('.entry').hover(
		function(){
			$(this).addClass('highlight');
			$(this).children('.buttons').append(getButtonHtml('edit', $(this).attr('id'), 'primary', 'pencil'));
			$(this).children('.buttons').append(getButtonHtml('delete', $(this).attr('id'), 'danger', 'trash'));
							
			$('.btn-edit').click(function(){
				
				/* Create editing textarea for this entry */
				var btnid = $(this).attr('id');
				var btnidarr = btnid.split("-");
				var idToEdit = btnidarr[2];
				console.log("Editing " + idToEdit);
				
				var textToEdit = $(this).parent().parent().parent().children('.summary').text().trim();
				var submit = '<button class="btn btn-savechanges btn-default" id="btn-savechanges-'+idToEdit+'">Save changes</button>';
				var cancel = '<button class="btn btn-cancel btn-default" id="btn-cancel-'+idToEdit+'">Cancel</button>';
				$(this).parent().parent().parent().children('.summary').html(getTextareaHtml(textToEdit, 'textarea-'+idToEdit) + submit + " " + cancel);
				
				/* cancel button - cancel editing when clicked */
				$('.btn-cancel').click(function(){
					console.log("Cancelling changes to " + idToEdit);
					$(this).parent().html(textToEdit);
				});
				
				/* save changes button - apply primary styling on hover */
				$('.btn-savechanges').hover(
					function(){
						$(this).addClass('btn-primary');	
						$(this).removeClass('btn-default');									
					},
					function(){
						$(this).addClass('btn-default');	
						$(this).removeClass('btn-primary');		
					}
				);
				
				/* save changes button - save changes when clicked */
				$('.btn-savechanges').click(function(){
					console.log("Saving changes");
					var btnid = $(this).attr('id');
					var btnidarr = btnid.split("-");
					var idToUpdate = btnidarr[2];
					console.log("Updating " + idToUpdate);
					
					var textUpdated = $('#textarea-'+idToUpdate).val();
					
					$.ajax({
						url: "ajaxUpdate",
						data: {
							idToUpdate: idToUpdate,
							textUpdated: textUpdated
						},
						type: "POST",
						success: function ( titleUpdated ) {
							console.log("Success; updated " + idToUpdate + " - " + titleUpdated);
							$('#'+btnid).parent().html(textUpdated.replace(/\n/g, "<br />"));
							$('#alerts').append(getAlertHtml('<span class="glyphicon glyphicon-saved"></span> Updated entry: '+ titleUpdated));
							$('.alertText').fadeOut(3000);
						},
						error: function () {
							console.log("An error occurred");
						}						
					});			
				});
				
			});
	
			$('.btn-delete').click(function() {
				var btnidDelete = $(this).attr('id');
				var btnidDeletearr = btnidDelete.split("-");
				var idToDelete = btnidDeletearr[2];
				console.log("Deleting element " + idToDelete);
				
				$.ajax({
					url: "ajaxDelete",
					data: {
						idToDelete: idToDelete
					},
					type: "POST",
					success: function ( titleDeleted ) {
						console.log("Successful: removing element " + titleDeleted);
						$('#'+btnidDelete).parent().parent().parent().fadeOut('fast');
						$('#alerts').append(getAlertHtml('<span class="glyphicon glyphicon-trash"></span> Removed entry: ' + titleDeleted));
						$('.alertText').fadeOut(3000);
					},
					error: function () {
						console.log("An error occurred");
					}
				});
				
			});		
		},
		function(){
			$('.buttons').children().remove();
		}
	);
});

function getTextareaHtml(text, name){
	return '<div class="form-group"><textarea id="'+name+'" class="form-control" placeholder="Description">'+text+'</textarea></div>';
}

function getButtonHtml(action, id, type, icon){
	return "<p><button class='btn btn-" + type + " btn-" + action + "' id='btn-"+ action + "-" + id + "'><span class='glyphicon glyphicon-" + icon + "'></span></button></p>";
}

function getAlertHtml(message){
	return "<h4 class='navbar-text alertText'>"+message+"</h4>";
}