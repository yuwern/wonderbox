		<div class="submission">
                	<div class="submis-left"><?php echo $this->Html->image('submission_ad.jpg'); ?></div>
                    <div class="submis-right">
                    	<div class="head">
                        	<h1><?php echo __l('WonderTreats Checkout'); ?></h1>
                        </div>
						<div class="step-bor end2">
						<?php if(!empty($beautyTip['BeautyTip']['is_delivery'])): ?>
                        	<ul>
								<li class="off1">SHIPPING DETAIL </li>
                                <li class="select">CHECK OUT</li>
                            </ul>
							<?php endif; ?>
                        </div>
                        <div class="shipp-left">
                        	<div class="shipp-box">
                            	<h3><?php echo __l('Subscription Package details'); ?></h3>
                                <ul>
                                	<li><?php echo __l('WonderTreats Name');?></li><li class="font-tahoma"> <?php echo $beautyTip['BeautyTip']['name'];?></li>
                                    <li><?php echo __l('Package Amount');?></li><li class="font-tahoma">&nbsp;&nbsp;  <?php echo  configure::read('site.currency'); ?><?php echo $this->Html->cFloat( $beautyTip['BeautyTip']['purchase_amount']); ?> </li>
                                </ul>
							</div>
							<div class="shipp-right">
								<?php $this->Gateway->$action($gateway_options); ?>
							</div>
                                                         
                        </div>                        
                    </div>
                </div>