<html>
<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" >
  <div class="container">
      <h3 class="navbar-text">Library</h3>
	  <button class="btn btn-primary navbar-btn" data-toggle="modal" data-target="#modalAddEntry"><span class="glyphicon glyphicon-plus"></span> Add entry</button>
	  <button class="btn btn-default navbar-btn" data-toggle="modal" data-target="#modalAddImage"><span class="glyphicon glyphicon-plus"></span> Add image</button>  
  <div id="alerts" class="navbar-right"></div>
  </div>
</nav>   <!-- Collect the nav links, forms, and other content for toggling -->

<div class="container">
	<div class="table-responsive" id="entries">
		<table class="table">
		  <thead>
		    <tr>
		      <th style="width: 20%;">Entry</th>
		      <th style="width: 70%;">Description</th>
		      <th style="width: 5%;"></th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php foreach($entries as $id => $entry): ?>
		    <tr class="entry" id="<?=$id?>">
		      <td>
		      	<b><a href="<?=$entry['link']?>"><?=$entry['title']?></a></b><br/><?=$entry['author']?>
		      </td>
		      <td class="summary">
		      <?php if($entry['type'] == 'image'): ?>
			  	<img src="<?= $entry['imagePath']?>" class="img-responsive img-rounded">		      
		      <?php else: ?>
		      	<?=$entry['description']?>
		      <?php endif; ?>
		     </td>
		     <td class="buttons">
		     
		     </td>
		    </tr>		  
		  <?php endforeach; ?>
		  </tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="modalAddEntry" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add an entry</h4>
      </div>
  	    <?=form_open('library/addEntry')?>
	    <div class="modal-body">
	      	<div class="form-group">
		  	  <input type="text" name="title" class="form-control input-lg" placeholder="Title">
	      	</div>
	      	<div class="form-group">
  		  	  <input type="text" name="author" class="form-control input-lg" placeholder="Author">
  		  	</div>
	      	<div class="form-group">
  		  	  <input type="text" name= "link" class="form-control input-lg" placeholder="Link">
			</div>
	      	<div class="form-group">
		  	  <textarea name="description" class="form-control" style="height: 100px;" placeholder="Description"></textarea>
		  	</div>
		  	<div class="form-group">
		  	  <input type="password" name="passphrase" class="form-control input-lg" placeholder="Passphrase">
	      	</div>
      </div>
      <div class="modal-footer">
	      <button type="submit" class="btn btn-primary">Add entry</button>	    
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalAddImage" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add an image</h4>
      </div>
  	    <?=form_open_multipart('library/addImage')?>
	    <div class="modal-body">
	      	<div class="form-group">
		  	  <input type="text" name="title" class="form-control input-lg" placeholder="Title">
	      	</div>
	      	<div class="form-group">
  		  	  <input type="text" name="author" class="form-control input-lg" placeholder="Author">
  		  	</div>
	      	<div class="form-group">
  		  	  <input type="text" name= "link" class="form-control input-lg" placeholder="Link">
			</div>
	      	<div class="form-group">
			   <input type="file" name="image">
		 </div>
		  	<div class="form-group">
		  	  <input type="password" name="passphrase" class="form-control input-lg" placeholder="Passphrase">
	      	</div>
      </div>
      <div class="modal-footer">
	      <button type="submit" class="btn btn-primary">Add image</button>	    
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>