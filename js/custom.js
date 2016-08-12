$(function() {
       $( "#j_datepicker" ).datepicker({
	    changeMonth: true,
	    changeYear: true,
	    dateFormat:'dd-mm-yy'
	});
	 $( "#j_datepicker1" ).datepicker({
	    changeMonth: true,
	    changeYear: true,
	    dateFormat:'dd-mm-yy'
	});
	 $( "#j_datepicker2" ).datepicker({
	    changeMonth: true,
	    changeYear: true,
	    yearRange: "-100:+0",
	    dateFormat:'dd-mm-yy'
	});
	$('.em_error_msg').delay(2000).fadeOut();
	$(".em_del_btn").click(function(){
	    var r = confirm("Are you sure to delete");
	    if(r == true){
		$('#em_del_form').submit();
	    }
	});	
	if ($(document).height() > $(window).height()) {
	    $(".footer").removeClass('fix-footer');
	}
	else{
	    $(".footer").addClass('fix-footer');
	}
	
	$(".get_cpf_type").change(function(){
	    $get_val = $(this).val();
	    if($get_val == 'andabove' || $get_val == 'andbelow'){
		  $(".aged_to_class").attr('readonly','readonly');
		  $('.aged_to_class').val(0);
	    }
	    else{
		 $(".aged_to_class").removeAttr('readonly');
	    }
	});
	$(".check_levy").click(function(){
	     if($(".check_levy").is(':checked')){
		     $(".get_levy").show();
		}
	    else{
		$(".get_levy").hide();
	    }
	});
	$('#add_datatbl').DataTable();
        
        
        $('.get_workingdays,.get_unpaidleave,.get_ot,.get_misc,.get_commission,.get_allowances').on('keyup keypress blur change', function(e) {
            total_salary();      
        });  
        
        $(".get_employercpf,.get_employeecpf,get_levy,.get_housing,.get_sdl").on('keyup keypress blur change', function(e) {
             total_contribution();
        });  

        $('.check_valid_uname').keypress(function (e) {
		    var regex = new RegExp("^[a-z0-9]+$");
		    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		    if (regex.test(str)) {
		        return true;
		    }

		    e.preventDefault();
		    return false;
		});
        
	$('#INV_client_id').change(function (){
		$('#INV_project_id').children('option').hide();
		$('#INV_project_id').children('option[class=show]').show();
		$("#INV_project_id option[value='']").prop('selected', true);
		$('#INV_project_id option:eq(0)').attr('selected','selected');
		$('#INV_no').val('');
		$('#INV_project_id').children('option[class='+$('#INV_client_id').val()+"]").show();
	});
	
	$('#INV_project_id').change(function (){
		var currentYear = (new Date).getFullYear();
		if($(this).find('option:selected').val() > 0){
			$('#INV_no').val('INV:EV/'+$(this).find('option:selected').attr('id')+"/"+$("#invoice_id").val()+"/"+currentYear);
		}else{
			$('#INV_no').val('');
		}
	});
	
	$('#QUO_client_id').change(function (){
		$('#QUO_project_id').children('option').hide();
		$('#QUO_project_id').children('option[class=show]').show();
		$("#QUO_project_id option[value='']").prop('selected', true);
		$('#QUO_project_id option:eq(0)').attr('selected','selected');
		$('#QUO_no').val('');
		$('#QUO_project_id').children('option[class='+$('#QUO_client_id').val()+"]").show();
	});
	
	$('#QUO_project_id').change(function (){
		var currentYear = (new Date).getFullYear();
		if($(this).find('option:selected').val() > 0){
			$('#QUO_no').val('QUO:EV/'+$(this).find('option:selected').attr('id')+"/"+$("#quotation_id").val()+"/"+currentYear);
		}else{
			$('#QUO_no').val('');
		}
	});
	
	$('#create_schedule').click(function (){
		$("#create_schedule_popup").modal("show");
	});
	
});

function total_salary(){
    var gettotal;
    var getgrosspay; 
    
    if($(".get_unpaidleave").val() !== 0){
        var get_payperday = $(".get_basicsalary").val() / $(".get_workingdays").val();
        var get_deductsalary = get_payperday * $(".get_unpaidleave").val();
        $(".get_totaldeduction").val(parseFloat(get_deductsalary).toFixed(2)); 
    } 
    
    getgrosspay = parseFloat($(".get_basicsalary").val()) + parseFloat($(".get_ot").val()) + parseFloat($(".get_misc").val()) + parseFloat($(".get_commission").val()) + parseFloat($(".get_allowances").val());
    $(".get_grosspay").val(parseFloat(getgrosspay).toFixed(2));
    
    gettotal  = $(".get_grosspay").val()  - $(".get_totaldeduction").val();
    $(".get_totalsalary").val(parseFloat(gettotal).toFixed(2));
}

function total_contribution(){
     var gettotal = 0;
     if($(".get_sdl").val()){
         gettotal = gettotal + parseFloat($(".get_sdl").val());
     }
     if($(".get_employercpf").val() || $(".get_employeecpf").val()){
         gettotal = gettotal + parseFloat($(".get_employercpf").val()) + parseFloat($(".get_employeecpf").val());
     }
     if($(".get_levy").val()){
         gettotal = gettotal + parseFloat($(".get_levy").val());
     }
     if($(".get_housing").val()){
         gettotal = gettotal + parseFloat($(".get_housing").val());
     }   
    $(".get_totalcontribution").val(parseFloat(gettotal).toFixed(2));
}

    