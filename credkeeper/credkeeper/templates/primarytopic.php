<?php 
/*echo "<pre>";
print_r($attributes);
echo "</pre>";*/
?>

<div class="scroll-bar-filter-wrapper">
<?php if(!empty($attributes->data)): ?>
<h3>Filters</h3>
<div class="scroll-bar-filter">
	<form id="primary_topic">
		
	<?php if(isset($attributes->data) && !empty($attributes->data)):
		foreach ($attributes->data as $idx => $category) : ?>
		<div class="accordion__item-<?php echo $idx?>">
			<div class="accordion__title-<?php echo $idx?> filter-beforenone">
				<label class="csm-check"><?php echo $category->primary_topic_name?><input name="primary_topic[]" value="<?php echo $category->id?>" type="checkbox">
				<span class="checkmark-filter"></span>
				</label></div>
		</div>
	<?php 	endforeach; ?>

		<input type="hidden" name="action" value="find_agent_by_zipcode">
		<input class="serch_btn" type="submit" name="Search" value="Search">
	<?php else: ?>
		<?php echo $attributes->msg?>
	<?php endif; ?>
	
	
	</form>
	<?php  endif; ?>


	<!-- <div class="accordion__item">
		<div class="accordion__title"><a href="javascript:vovid(0)"><label class="csm-check">Category
			<input type="checkbox">
			<span class="checkmark-filter"></span>
			</label></a></div>
		<div class="accordion__body">
			<div class="accordion__content">
				<ul>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					<input type="checkbox">
					<span class="checkmark-filter"></span>
					</label>
				 </li>
				 <li><label class="csm-check">Category
					<input type="checkbox">
					<span class="checkmark-filter"></span>
					</label>
				 </li>
				 <li><label class="csm-check">Category
					<input type="checkbox">
					<span class="checkmark-filter"></span>
					</label>
				 </li>
				 <li><label class="csm-check">Category
					<input type="checkbox">
					<span class="checkmark-filter"></span>
					</label>
				 </li>
				 <li><label class="csm-check">Category
					<input type="checkbox">
					<span class="checkmark-filter"></span>
					</label>
				 </li>
				 <li><label class="csm-check">Category
					<input type="checkbox">
					<span class="checkmark-filter"></span>
					</label>
				 </li>
				</ul>
			 </div>
		</div>
	</div>
	<div class="accordion__item">
		<div class="accordion__title"><a href="javascript:vovid(0)"><label class="csm-check">Features<input type="checkbox">
			<span class="checkmark-filter"></span>
			</label></a></div>
		<div class="accordion__body">
			<div class="accordion__content">
				<ul>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				</ul>
			 </div>
		</div>
	</div>
	<div class="accordion__item">
		<div class="accordion__title"><a href="javascript:vovid(0)"><label class="csm-check">Speciality<input type="checkbox">
			<span class="checkmark-filter"></span>
			</label></a></div>
		<div class="accordion__body">
			<div class="accordion__content">
				<ul>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				   <li><label class="csm-check">Category
					  <input type="checkbox">
					  <span class="checkmark-filter"></span>
					  </label>
				   </li>
				</ul>
			 </div>
		</div>
	</div> -->
	
	
</div>
</div>
