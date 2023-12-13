<?php

$currentUrl = current_url(true);
$request = service('request');
 $session = session();

?>
<!-- Main Content -->
<div class="page-wrapper">
    <div class="container-fluid">
  <!-- Title -->
  <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark"></h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="index.html">Single User</a></li>

                    <li class="active"><span> <?= $currentUrl->getSegment(4) ?></span></li>
                </ol>
            </div>
            <!-- /Breadcrumb -->
        </div>
        <!-- /Title -->


<div class="user-profile">
<div class="col-sm-12">
    
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
            <h4>First Name</h4>
            <p>            <?= $userDetail[0]->first_name ?></p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Last Name</h4>
            <p>            <?= $userDetail[0]->last_name ?></p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Gender</h4>
            <p>Male</p> 
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
            <h4>Date of Birth</h4>
            <p>            <?= $userDetail[0]->dob ?></p>           </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
          <h4>User Name</h4>
            <p>lnbdigital</p>  
          </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
          <h4>User Email</h4>
          <p>            <?= $userDetail[0]->email ?></p>   
          </div>
        </div>
        
      
        <div class="col-sm-3">
          <div class="well">
          <h4>User Id</h4>
          <p>            <?= $userDetail[0]->user_id ?></p>           </div>
        </div>
        <div class="col-sm-3">
          <div class="well">
          <h4>User Status</h4>
          <p>  <?php if($userDetail[0]->is_active == 0){
                          echo 'Unverified';
          }else if($userDetail[0]->is_active == 1){
            echo 'Active';
          }else if($userDetail[0]->is_active == 2){
            echo 'Blocked';
          } ?>       
          
        </p></div>
        </div>
      </div>
      
        
        
    </div>

</div>
</div>