<?PHP
include("includes/common.php");
$pid=$_GET['pid'];
if($pid=='')
	{
		exit;	
	}
?>
  <section class="panel">
   <div class="panel-body">
                        <div class="form-group">
                        <label class="col-sm-3 control-label col-lg-3">&nbsp;</label>
                        <div class="col-lg-6">                        
                        <span class="text-inverse">Please upload only pdf file. Other files are not allowed.<br /><br /></span>
                        </div>
                        </div>
						<div style="clear:both;"></div>
                        
                        <div class="form-group"> 
                        <label class="col-sm-3 control-label col-lg-3">Linking Report</label>
                        <div class="col-lg-6">               
                        <input name="reportname1" type="hidden" value="Linking Report" id="reportname1" />
                        <div class="input-group m-bot15">
                        <span class="input-group-addon btn-white"><i class="fa fa-cloud-upload text-inverse"></i></span>
                        <div class="wrap-input100 validate-input m-b-23">
                        <input name="img1" type="file" id="img1" class="form-control" />                        
                        </div>
                        </div>
						</div>
                        </div>
                        
                        
                       <div style="clear:both;"></div>
                        
                        <div class="form-group"> 
                        <label class="col-sm-3 control-label col-lg-3">Onsite Report</label>
                        <div class="col-lg-6">               
                        <input name="reportname2" type="hidden" value="Onsite Report" id="reportname2" />
                        <div class="input-group m-bot15">
                        <span class="input-group-addon btn-white"><i class="fa fa-cloud-upload text-inverse"></i></span>
                        <div class="wrap-input100 validate-input m-b-23">
                        <input name="img2" type="file" id="img2" class="form-control" />                        
                        </div>
                        </div>
						</div>
                        </div>
						
						<div style="clear:both;"></div>
                        
                        <div class="form-group"> 
                        <label class="col-sm-3 control-label col-lg-3">Ranking Report</label>
                        <div class="col-lg-6">               
                        <input name="reportname3" type="hidden" value="Ranking Report" id="reportname3" />
                        <div class="input-group m-bot15">
                        <span class="input-group-addon btn-white"><i class="fa fa-cloud-upload text-inverse"></i></span>
                        <div class="wrap-input100 validate-input m-b-23">
                        <input name="img3" type="file" id="img3" class="form-control" />   
                        </div>
                        </div>      
						</div>
                        </div>
						
						<div style="clear:both;"></div>
						
						<div class="form-group"> 
                        <label class="col-sm-3 control-label col-lg-3">Report for Month</label>
                        <div class="col-lg-6">               
                        <div class="input-group m-bot15">
                        <div class="wrap-input100 validate-input m-b-23">
                       <select name="rmonth"  class="input-sm form-control w-sm inline v-middle" required>
						<option value="">--Month--</option>
						<option value="01">01</option>
						<option value="02">02</option>
						<option value="03">03</option>
						<option value="04">04</option>
						<option value="05">05</option>
						<option value="06">06</option>
						<option value="07">07</option>
						<option value="08">08</option>
						<option value="09">09</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						</select> 
						<select name="ryear"  class="input-sm form-control w-sm inline v-middle" required>
						<option value="">--Year--</option>
						<option value="2022">2022</option>
						<option value="2023">2023</option>
						</select>                            
                        </div>
                        </div>
						</div>
                        </div>
						
						<div style="clear:both;"></div>
                        
                        <div class="form-group">
                        <div class="col-lg-3">&nbsp;</div> 
                        <div class="col-lg-6">    
                        <input type="text" name="pid" value="<?PHP echo $_REQUEST['pid']; ?>">   
                        <input type="text" name="reportmonth" value="<?PHP echo $_REQUEST['reportmonth']; ?>">
                         <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                        </div>

				</div>
                    </section>

