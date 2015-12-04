<?php
/**
 * @version		$Id: tag.php 1766 2012-11-22 14:10:24Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<!-- Start K2 Tag Layout -->
<div id="k2Container" class="tagView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if($this->params->get('show_page_title')): ?>
	<!-- Page title -->
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
	<?php endif; ?>

	<?php if($this->params->get('tagFeedIcon',1)): ?>
	<!-- RSS feed icon -->
	<div class="k2FeedIcon">
		<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

	<?php if(count($this->items)): ?>
	<div class="catItemList">
		<?php 
			$i=0; 
			foreach($this->items as $item): ?>
		<?php
				$inumber = 2;
				if($i< $inumber) $i++;
				elseif ($i== $inumber) $i=1;
			?>
		<!-- Start K2 Item Layout -->
		<div class="catItemView <?php  echo'item'.$i;?>">

			
		  <div class="catItemBody ">	
				<?php if($item->params->get('tagItemImage',1) && !empty($item->imageGeneric)): ?>
				<!-- Item Image -->
				<div class="catItemImageBlock pull-left">
					<div class="catItemImage">
						<img src="<?php echo $item->imageGeneric; ?>" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>"  />
						<?php //Hover item images ?>
						<div class="image-overlay">
							<div class="hover-links clearfix">
								<a class="hover-zoom" data-rel="prettyPhoto"  href="<?php echo $item->imageXLarge; ?>">
									<i class="icon-resize-full"></i>
								</a>
								<a class="hover-link" href="<?php echo $item->link; ?>" title="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>">
									<i class="icon-link"></i>
								</a>
							</div>
						</div>
					</div>
			
				</div>
				<?php endif; ?>
				  
			    

              
			  <?php if($item->params->get('tagItemIntroText',1)): ?>
			  <!-- Item introtext -->
			  <div class="catItemBody">
                <div class="catItemHeader">
					<dl class="article-info">
						<?php if($item->params->get('tagItemDateCreated',1)): ?>
						<!-- Date created -->
						<dd class="catItemDateCreated">
							<i class="icon-calendar"></i>
							<?php echo JHTML::_('date', $item->created , JText::_('K2_DATE_FORMAT_LC')); ?>
						</dd>
						<?php endif; ?>
						<?php if($item->params->get('tagItemCategory')): ?>
						<!-- Item category name -->
						<dd class="catItemCategory">
							<i class="icon-briefcase"></i>
							<a href="<?php echo $item->category->link; ?>"><?php echo $item->category->name; ?></a>
						</dd>
						<?php endif; ?>
						
						
					</dl>
                </div>	
				<?php if($item->params->get('tagItemTitle',1)): ?>
                  <!-- Item title -->
                  <h3 class="catItemTitle">
                    <?php if ($item->params->get('tagItemTitleLinked',1)): ?>
                        <a href="<?php echo $item->link; ?>">
                        <?php echo $item->title; ?>
                    </a>
                    <?php else: ?>
                    <?php echo $item->title; ?>
                    <?php endif; ?>
                  </h3>
                 <?php endif; ?>				
			  	<?php echo $item->introtext; ?>
               
               <?php if ($item->params->get('tagItemReadMore')): ?>
                <!-- Item "read more..." link -->
                    <a class="readmore" href="<?php echo $item->link; ?>">
                        <?php echo JText::_('K2_READ_MORE'); ?> <i class="ico-arrow-right"></i>
                    </a>
                <?php endif; ?>
			  </div>
			  <?php endif; ?>

			  <div class="clr"></div>
		  </div>
		  
		  <div class="clr"></div>
		  
		  <?php if($item->params->get('tagItemExtraFields',0) && count($item->extra_fields)): ?>
		  <!-- Item extra fields -->  
		  <div class="catItemExtraFields">
		  	<h4><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h4>
		  	<ul>
				<?php foreach ($item->extra_fields as $key=>$extraField): ?>
				<?php if($extraField->value != ''): ?>
				<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
					<?php if($extraField->type == 'header'): ?>
					<h4 class="catItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
					<?php else: ?>
					<span class="catItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
					<span class="catItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
					<?php endif; ?>		
				</li>
				<?php endif; ?>
				<?php endforeach; ?>
				</ul>
		    <div class="clr"></div>
		  </div>
		  <?php endif; ?>
		  
			

			<div class="clr"></div>
		</div>
		<!-- End K2 Item Layout -->
		
		<?php endforeach; ?>
	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
		<div class="clr"></div>
		<?php echo $this->pagination->getPagesCounter(); ?>
	</div>
	<?php endif; ?>

	<?php endif; ?>
	
</div>
<!-- End K2 Tag Layout -->
