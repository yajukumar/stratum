<?php StmFactory::getApplication()->setDocumentTitle('Questions');
?>
<?php if(!StmFactory::getSession()->get('userid')) { ?>
<?php
} else {

	//StmFactory::getApplication()->redirect('view=userprofile');
	
	if($action == 'new')
	{
	
		StmFactory::getSession()->set('breadcrumbs',array('Home'=>'#','Evaluations'=>'#','New Evaluation'=>''));
	}
	else
	{
		StmFactory::getSession()->set('breadcrumbs',array('Home'=>'#','Evaluations'=>'#','Pending Evaluation'=>''));
	}



	?>

	
	
<?php 

$model = new ModelQuestionnaire;

?>

<div id='box' style="position:relative">
<div class='top_container'>
	<div class="text-center  save_message pull-left">
		<p></p>	
	</div>
	<div class="text-right save-button pull-right">
		<button id='save_continue' class="btn btn-large btn-primary " >Save Progress</button>
	<p id="save_parent" style="float:right;margin-left:10px"><button id='save' class="btn btn-large btn-success disabled" >Submit</button></p>
	</div>
</div>
<div style="padding:30px 10px 0px 20px">
<form action="" method='POST' class="">

<?php $count = 1;

 // print_r($data);die;
foreach ($data as $key => $questions) 
{
	$counter = 1;
	$title = explode("--",$key);

	// echo "<div class='category>";
	echo "<section id='counter-".$title[1]."' >";
		echo "<h3  class='title' >".$title[0]."</h3>";
		echo "<br/>";
	foreach ($questions as $k => $row) 
	{
		echo "<div  class='question-container' ><p class='question'>Q.".$counter.". ".$row['question']."</p><div class='options-container'>";
		$question_id = $row['id'];
		$question_type = $row['type'];
		switch($question_type)
		{
			case 'list': 
			{
				$model->getOptions($row['id'],$level = 1,$action,$e_id);

			}
			break;
			case 'table':
			{

				$model->drawTable($row['id'],$level = 1,$action,$e_id);
			}
		}
		$counter++;
		
		echo "</div>";
		echo "</div>";
	}
	echo "<hr/>";
	
	echo "<br/>";
	$count++;
	 echo "</section>";
}


?>

</form>
</div>
<div class="text-right submit-button">
	<!-- <button id='save' class="btn btn-large btn-success ">Submit</button> -->
</div>
</div>
<?php 

}
?>

<script>


		function enableSubmit()
		{
			flag = true;
			counter =0;
			$("nav").find("li").each(function(){
				if(counter!=0)
				{
					if($(this).hasClass('done') == false)
					{
						flag = false
					}
					
				}
				counter++;
			});

			if(flag)
			{
				$("#save").removeClass('disabled');
			}
			else
			{
				$("#save").addClass('disabled');
			}
			

		}
		function markprogress()
		{
			$("body").on('click','input:checkbox:visible,input:radio:visible',function(){
			
				cat_id = $(this).data('cat-id');
				
				
					 all_radio_answered = true;
					 all_text_answered = true;
					 all_checkbox_answered = true;
					 partial_radio_answered = false;
					 partial_checkbox_answered = false
					 partial_text_answered = false
					// section_id = $(parent_section).attr('id');
					section_id = "counter-" + cat_id;
					parent_section = $("#"+section_id);

					parent_section.find("input:radio:visible").each(function(){
						  name = $(this).attr("name");
						  if($("input:radio[name="+name+"]:checked").length == 0)
						  {						  	
						    	all_radio_answered = false;
						    	// return false;
						  }
						  else if($("input:radio[name="+name+"]:checked").length > 0)
						  {
						  	partial_radio_answered = true
						  }

					});
							

					parent_section.find("input:text:visible").each(function(){
						  name = $(this).attr("name");
						  if($("input:text[name="+name+"]").val().trim() == "")
						  {
						    all_text_answered = false;
						    // return false;
						  }
						  else
						  {
						  	partial_text_answered = true;

						  }
					});
					
					

					parent_section.find("input:checkbox:visible").each(function(){
						  name = $(this).attr("name");
						  
						  if($("input:checkbox[name="+name+"]:checked").length == 0)
						  {
						    all_checkbox_answered = false;
						    // return false;
						  }
						  else if($("input:checkbox[name="+name+"]:checked").length > 0)
						  {
						  	partial_checkbox_answered = true;
						  }
					});
					
					
					
					if(all_radio_answered && all_text_answered && all_checkbox_answered)
					{
			      			
						nav_item = $("nav").find("li[data-id='"+section_id+"']")
						nav_item.removeClass('partial');
			      			nav_item.addClass('done');
					}
					else if(  partial_radio_answered  || partial_text_answered || partial_checkbox_answered ) 
					{
						
						nav_item = $("nav").find("li[data-id='"+section_id+"']")
			      			nav_item.removeClass('done');
			      			nav_item.addClass('partial');

					}
					else
					{
						
						nav_item = $("nav").find("li[data-id='"+section_id+"']")
				      		nav_item.removeClass('done');
				      		nav_item.removeClass('partial');
					}
					enableSubmit();
							
				
			})
			$("body").on('blur',"input:text:visible",function(){
				
				cat_id = $(this).data('cat-id');
				
				
					 all_radio_answered = true;
					 all_text_answered = true;
					 all_checkbox_answered = true;
					 partial_radio_answered = false;
					 partial_checkbox_answered = false
					 partial_text_answered = false
					// section_id = $(parent_section).attr('id');
					section_id = "counter-" + cat_id;
					parent_section = $("#"+section_id);

					parent_section.find("input:radio:visible").each(function(){
						  name = $(this).attr("name");
						  if($("input:radio[name="+name+"]:checked").length == 0)
						  {						  	
						    	all_radio_answered = false;
						    	// return false;
						  }
						  else if($("input:radio[name="+name+"]:checked").length > 0)
						  {
						  	partial_radio_answered = true
						  }

					});
					

					parent_section.find("input:text:visible").each(function(){
						  name = $(this).attr("name");
						  if($("input:text[name="+name+"]").val().trim() == "")
						  {
						    all_text_answered = false;
						    // return false;
						  }
						  else
						  {
						  	partial_text_answered = true;

						  }
					});
					
					
					parent_section.find("input:checkbox:visible").each(function(){
						  name = $(this).attr("name");
						  
						  if($("input:checkbox[name="+name+"]:checked").length == 0)
						  {
						    all_checkbox_answered = false;
						    // return false;
						  }
						  else if($("input:checkbox[name="+name+"]:checked").length > 0)
						  {
						  	partial_checkbox_answered = true;
						  }
					});
					
					
					if(all_radio_answered && all_text_answered && all_checkbox_answered)
					{
			      			
						nav_item = $("nav").find("li[data-id='"+section_id+"']")
						nav_item.removeClass('partial');
			      			nav_item.addClass('done');
					}
					else if(  partial_radio_answered  || partial_text_answered || partial_checkbox_answered ) 
					{
						
						nav_item = $("nav").find("li[data-id='"+section_id+"']")
			      			nav_item.removeClass('done');
			      			nav_item.addClass('partial');

					}
					else
					{
						
						nav_item = $("nav").find("li[data-id='"+section_id+"']")
				      		nav_item.removeClass('done');
				      		nav_item.removeClass('partial');
					}
					enableSubmit();
					
			})
			
			
			
		//  Do not delete 
		}
		$(document).ready(function(){
			
			$("input[type=radio],input[type=checkbox]").parent().next('.child').hide();
			$("input[type=radio]:checked,input[type=checkbox]:checked").parent().next('.child').show();

			
			markprogress();
			
				
				$("section").each(function(){
				
					 all_radio_answered = true;
					 all_text_answered = true;
					 all_checkbox_answered = true;
					 partial_radio_answered = false;
					 partial_checkbox_answered = false;
					 partial_text_answered = false;
					// section_id = $(parent_section).attr('id');
					section_id = $(this).attr('id')
					

					$(this).find("input:radio:visible").each(function(){
						  name = $(this).attr("name");
						  if($("input:radio[name="+name+"]:checked").length == 0)
						  {
						    all_radio_answered = false;
						    // return false;
						  }
						  else if($("input:radio[name="+name+"]:checked").length > 0)
						  {
						  	partial_radio_answered = true;
						  }
					});
					
					

					$(this).find("input:text:visible").each(function(){
						  name = $(this).attr("name");
						  if($("input:text[name="+name+"]").val().trim() == "")
						  {
						      all_text_answered = false;
						      // return false;
						  }
						  else{
						  	partial_text_answered = true;
						  }
					});
					
					

					$(this).find("input:checkbox:visible").each(function(){
						  name = $(this).attr("name");
						  if($("input:checkbox[name="+name+"]:checked").length == 0)
						  {							
						    all_checkbox_answered = false;
						    // return false;
						  }
						  else if($("input:checkbox[name="+name+"]:checked").length > 0)
						  {
						  	partial_text_answered = true;
						  }
					});
					
					
					
					if(all_radio_answered && all_text_answered && all_checkbox_answered)
					{
			      			
						nav_item = $("nav").find("li[data-id='"+section_id+"']")
						nav_item.removeClass('partial');
			      			nav_item.addClass('done');
					}
					else if(  partial_radio_answered  || partial_text_answered || partial_checkbox_answered )
					{
						
						nav_item = $("nav").find("li[data-id='"+section_id+"']")
			      			nav_item.removeClass('done');
			      			nav_item.addClass('partial');

					}
					else
					{
						
						nav_item = $("nav").find("li[data-id='"+section_id+"']")
			      			nav_item.removeClass('done');
			      			nav_item.removeClass('partial');
					}
				
			});
			

			$("input[type=radio],input[type=checkbox]").on('click',function(){
				if($(this).is(":checked"))
				{
					 $(this).parent().next('.child').show()
				}
				else
				{
					$(this).parent().next('.child').hide()
				}
				$("input[type=radio],input[type=checkbox]").parent().next('.child').hide();
				$("input[type=radio]:checked,input[type=checkbox]:checked").parent().next('.child').show()

				
			});
			
			



			$("#save").click(function(){
				if($(this).hasClass('disabled'))
				{
					return false;
				}
				data = {};
				data['eid'] = <?php echo $e_id;?>;
				data['data'] = {};
				$('input[type=text]:visible').each(function(){
					id = $(this).data('id');
					val = $(this).val();
					if(val !="")
					{
						data['data'][id] = val;
					}
				})
				$('input[type=radio]:visible').each(function(){
					id = $(this).data('id');
					val = "";// $(this).val();
					if($(this).is(":checked"))
					{
						data['data'][id] = val;
						
					}
				})
				$('input[type=checkbox]:visible').each(function(){
					id = $(this).data('id');
					val = '';//$(this).val();
					if($(this).is(":checked"))
					{
						data['data'][id] = val;
					}
				})
				$('select:visible option').each(function(){
					//console.log($(this))
					id = $(this).attr('data-id');
					val = '';//$(this).val();
					if($(this).is(":selected"))
					{
						data['data'][id] = val;
					}
				})
				
				$.ajax({
				  type: "POST",
				  url: "?view=questionnaire&action=submit",
				  data: data,
				  beforeSend:function(){
				  	$("#modal").modal({backdrop:'static',keyboard:false})
				  	$("#modal").modal("show")
				  },
				  success: function(res)
				  {
				  	//console.log(res);
				  	//location.reload();
				  	$("#modal").find(".modal-content").html("<h3>Thank you!</h3><label>Your evaluation has been submitted successfully.</label><label>You will be redirected to <a href='?view=user&action=archive'>\"My Evaluations\" </a>in 5 seconds. </label>")
				  	setTimeout(function(){
				  		window.location.assign("?view=user&action=archive")				  		;
				  	},5000)
				  	
				  }
				  
				});
				
			});

			$("#save_continue").click(function(){
				data = {};
				data['eid'] = <?php echo $e_id;?>;
				data['data'] = {};
				$('input[type=text]:visible').each(function(){
					id = $(this).data('id');
					val = $(this).val();
					if(val !="")
					{
						data['data'][id] = val;
					}
				})
				$('input[type=radio]:visible').each(function(){
					id = $(this).data('id');
					val = "";// $(this).val();
					if($(this).is(":checked"))
					{
						data['data'][id] = val;
						
					}
				})
				$('input[type=checkbox]:visible').each(function(){
					id = $(this).data('id');
					val = '';//$(this).val();
					if($(this).is(":checked"))
					{
						data['data'][id] = val;
					}
				})
				$('select:visible option').each(function(){
					//console.log($(this))
					id = $(this).attr('data-id');
					val = '';//$(this).val();
					if($(this).is(":selected"))
					{
						data['data'][id] = val;
					}
				})
				
				$.ajax({
				  type: "POST",
				  url: "?view=questionnaire&action=save",
				  data: data,
				  success: function(res)
				  {
				  	// console.log(res)
				  	//location.reload();
				  	if(res=="true")
				  	{
				  		$(".save_message").fadeIn().removeClass('error').find("p").html("Progress saved successfully!").parent(".save_message").delay(1500).fadeOut();
				  		
				  	}
				  	else
				  	{
				  		$(".save_message").fadeIn().addClass('error').find("p").html("Some error occured!").parent(".save_message").delay(1500).fadeOut();
				  	}

				  	//window.location.assign("?view=thankyou")
				  	
				  }
				  
				});
				
			});


			
			   nav = $('nav#left-menu');
			  nav_height = nav.outerHeight();
			  nav_top = $("nav#left-menu ul.menu").position().top
			  
			$(window).on('scroll', function () {
				
				if($(this).scrollTop() >= nav_top)
				{
					$("nav#left-menu ul.menu").css({'top':'0'});
					$("nav#left-menu ul.menu").css({'position':'fixed'});
					$(".top_container").css({'top':$(this).scrollTop()-162});
					$(".top_container").css({'position':'absolute'});
					$(".top_container").css({'background':'#E5E2E9'});
					$(".top_container").css({'box-shadow': '0px 0px 5px #555'});
					

				}
				else
				{
					$("nav#left-menu ul.menu, .top_container").css({'position':'inherit'});
					$("nav#left-menu ul.menu,.top_container").css('top','auto');
					$(".top_container").css({'background':'none'});
					$(".top_container").css({'box-shadow':'none'});
				}	
				
				if($(window).scrollTop() + $(window).height() == $(document).height() ) {


     					  $("nav#left-menu ul.menu").css('max-height',$(window).height()-70);
     					  $('nav#left-menu ul').animate({
					    scrollTop: $("nav#left-menu ul").height()
					  }, 800);
   				}
   				else
   				{
   					$("nav#left-menu ul.menu").css('max-height','100%');	
   				}

   				if($(window).scrollTop() >= 0 && $(window).scrollTop() <= 160) 
   				{
   					$("nav#left-menu ul.menu").css('max-height',$(window).height());
   				}	


   				

				   cur_pos = $(this).scrollTop();

				  $("section").each(function() {

				   section_top = $(this).offset().top - 100; 
				   section_bottom = section_top + $(this).outerHeight();
				   
				    if (cur_pos >= section_top && cur_pos <= section_bottom) 
				    {
				      // nav.find('li').removeClass('active');
				      $("section").removeClass('active');			      
				      $(this).addClass('active');
				      id = $(this).attr('id');
				      $("nav li").removeClass('active');

				      
	   				// console.info($("nav#left-menu ul").offset())
	   				//console.error($(window).scrollTop() - nav_item.offset().top)	

				      	      
				    }
				 

				  });
					//highlight last item in menu if the section height is less than viewport				
					if($(window).scrollTop() + $(window).height() == $(document).height() ) 
					{
							//scrolled to bottom
							last_section_height = $("section:last-child").outerHeight();
							if(last_section_height <  ($(window).height() - 50) )
							{

								$("section").removeClass('active');			      
								$("section:last-child").addClass('active');

								id = $("section:last-child").attr('id');
								
								$("nav li").removeClass('active');
								nav_item = $("nav").find("li[data-id='"+id+"']")
								nav_item.addClass('active');	
							}
						}
					 

				});


				nav.find('li').on('click', function (event) {



				    id = $(this).attr("data-id");
				    
				    el = $("section#"+id)
					
			  	
				  $('html, body').animate({
				    scrollTop: (el.offset().top - 80) 
				  }, 800);

				  
				  return false;
				});
			
			enableSubmit();
			nav_item = $("nav").find("li[data-id='"+id+"']")
				      nav_item.addClass('active');
				      	
				      	nav_viewport_height = $("nav#left-menu ul").height();
				      	active_position =  nav_item.position().top
				      	if(active_position>nav_viewport_height)
				      	{
				      		$('nav#left-menu ul').animate({
						    scrollTop: active_position
						  }, 800);
				      	}
				      	if(active_position< 0)
				      	{
				      		$('nav#left-menu ul').animate({
						    scrollTop: 0
						  }, 800);
				      	}
			
		})


$('#save_parent').tooltip({"trigger":"hover focus","placement":"bottom", "title":"Please answer all the questions to submit this evaluation. "});

</script>

<div class="modal fade " tabindex="-1" role="dialog" id="modal" aria-labelledby="" aria-hidden="true" style="z-index:99999 !Important">
  <div class="modal-dialog ">
    <div class="modal-content text-center">
    	<h3>Submitting evaluation</h3>
    <div class="progress-bar progress-bar-success progress-bar-striped active center-block" style="float:none; width:80%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
						Please wait.
			</div>

    	<label style="margin-bottom:20px;margin-top:10px">Do not press "Back" or Refresh the Page. </label>
      	
</div>
    </div>
  </div>



<!-- </div> -->