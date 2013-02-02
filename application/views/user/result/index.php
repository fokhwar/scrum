<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title> Scrum Meeting Results </title>
		<link rel='stylesheet' type='text/css' href='<?php echo base_url();?>css/reset.css'/>
		<link rel='stylesheet' type='text/css' href='<?php echo base_url();?>css/jquery.ui.all.css'/>
		<link rel='stylesheet' type='text/css' href='<?php echo base_url();?>css/style.css'/>
		<script type='text/javascript' src='<?php echo base_url();?>js/jquery.js'></script>
		<script type='text/javascript' src='<?php echo base_url();?>js/jquery-ui.js'></script>
		<script type='text/javascript' src='<?php echo base_url();?>js/jquery.validate.js'></script>
		<script type='text/javascript' src='<?php echo base_url();?>js/initialize.js'></script>
		<script type='text/javascript' src='<?php echo base_url();?>js/loader.js'></script>
		<script>
			$(document).ready(function(){
				Initialize();
				$("#tabs").tabs().tabs('select', <?php echo date('w',now())-1;?>);
				$('.success').hide().fadeIn(1000);
				LoadTodo('<?php echo $this->config->item('link_url');?>user/result/gettodobydev');
				LoadEditData('<?php echo $this->config->item('link_url');?>');
			});
		</script>
	</head>
	<body>
		<div id='container'>
			<div id='header'>
				<div class='current'>
					<a href='<?php echo base_url();?>'>TODAY</a>
				</div>
				<h1> Scrum Meeting Results </h1>
			</div>
			<div id='content'>
				<div id='operation'>
					<div class='add_result'>
						<a href='#' id="add"><span style='color:green'>+</span>Add a result</a>
					</div>
					<div class='show_week'>
						<p>
							<a href='<?php echo $this->config->item('link_url');?>user/result/show/<?php echo $prev_startDate;?>'><img src='<?php echo base_url();?>images/pre.png' class='left'/>Previous Week</a>
							<span class='show_date'>From <span class='date'><?php echo $startDate;?></span> To <span class='date'><?php echo $endDate;?></span></span>
							<a href='<?php echo $this->config->item('link_url');?>user/result/show/<?php echo $next_startDate;?>'><img src='<?php echo base_url();?>images/next.png' class='right'/>Next Week</a>
						</p>
					</div>
					<br class='clear'/>
				</div>
				
				<div class='success'>
					<?php echo $this->session->flashdata('success');?>
				</div>
				
				<div id='results'>
					<div id="tabs">
						<ul>
							<?php 
								$i = 1;
								foreach($results as $result):
							?>
									<li>
										<a href='#tabs-<?php echo $i++;?>'>
											<?php
												if($result['date'] == date('d-m-Y',now()))
													echo 'Today';
												else if($result['date'] == date('d-m-Y',strtotime(date('d-m-Y',now()).'-1 day')))
													echo 'Yesterday';
												else
													echo $result['date'];
											?>
										</a>
									</li>
							<?php 
								endforeach;
							?>
						</ul>
						
						<?php
							$i = 1;
							foreach($results as $result):
						?>
								<div id="tabs-<?php echo $i++;?>">
								<?php if(count($result['result']) > 0):?>
									<ul>
										<?php foreach($result['result'] as $r):?>
											<li>
												<p>
													<span class='operation'>
														<?php if($result['date'] == date('d-m-Y',now())):?>
															<a href='<?php echo $this->config->item('link_url').'user/result/deleteresult/'.$r->id;?>'>Delete</a>
															<a href='#' class='edit' id='<?php echo $r->id." ".$r->dev_id;?>'>Edit</a>
															
														<?php endif;?>
														<a href='#' class='note'>Note</a>
													</span>
													
													<img src='<?php echo base_url();?>images/dev.png'/>
													<span class='dev'><?php echo $this->developer_model->GetDevelopers(array('id'=>$r->dev_id))->name;?></span>
													
													<span style='color:green'>To do :</span>
													<?php echo $r->to_do;?>
													
													</br/>
													
												 	<span class='show_note'>
												 		<?php if($result['date'] != date('d-m-Y',now())):?>
												 			<span style='color:green'>Finish Tasks :</span>
															<?php echo $r->finish_task;?><br/>
														<?php endif;?>
														
												 		<span style='color:green'>Note :</span>
												 		<?php echo $r->note;?>
												 	</span>
												</p>
											</li>
										<?php endforeach;?>
									</ul>
								<?php else: ?>
									<p>There is no data.</p>
								<?php endif;?>
								</div>
						<?php
							endforeach;
						?>
					</div>
				</div>
			</div>
			<div id='footer'>
				<p> Copyright &copy; fokhwar 2012. All Rights reserved.</p>
			</div>
			
			<div id="dialog-message" title="Add result">
				<form method='POST' action='<?php echo $this->config->item('link_url');?>user/result/addresult' id='result_form'>
					<label>Select Developer<span class='require'>*</span></label>
					<select name='dev_id' id='dev'>
						<option>Select One</option>
						<?php
							$developers = $this->developer_model->GetDevelopers();
							foreach($developers as $developer):
						?>
								<option value="<?php echo $developer->id;?>"><?php echo $developer->name;?></option>
						<?php endforeach;?>
					</select>
					<span class='check_info error'><?php echo $this->config->item('check_info');?></span><br/>
					
					<label id='show_label' style='float:left'>To do (Yesterday)</label>
					<span id="show_todo">
						<img src="<?php echo base_url();?>images/loader.gif" id="loader" alt="" />
					</span><br/>
					
					<label class='top-20'>Finish Task<span class='require'>*</span></label>
					<textarea cols='60' rows='5' name='finish_task' id='finish'></textarea><br/>
					
					<label> To do (Today)<span class='require'>*</span></label>
					<textarea cols='60' rows='5' name='to_do' id='todo'></textarea><br/>
					
					<label>Note</label>
					<textarea cols='60' rows='5' name='note' id='note'></textarea><br/>
					
					<input type='submit' name='' value='Add Result' id='submit'/>
				</form>
			</div>
		</div>
	</body>
</html>