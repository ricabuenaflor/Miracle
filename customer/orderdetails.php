<?php 

if (!isset($_SESSION['CUSID'])){
redirect(web_root."index.php");
}
 

     

$customerid =$_SESSION['CUSID'];
$customer = New Customer();
$singlecustomer = $customer->single_customer($customerid);

  ?>
 
<?php 
  $autonumber = New Autonumber();
  $res = $autonumber->set_autonumber('ordernumber'); 
?>


<form onsubmit="return orderfilter()" action="customer/controller.php?action=processorder" method="post" >   
<section id="cart_items">
    <div class="container">
      <div class="breadcrumbs">
          <h4><a href="">Order Details</a><h4>
        <br>
        <br>
      </div>
      <div class="row">
    <div class="col-md-6 pull-left">
      <div class="col-md-2 col-lg-2 col-sm-2" style="float:left">
        Name:
      </div>
      <div class="col-md-8 col-lg-10 col-sm-3" style="float:left">
        <?php echo $singlecustomer->FNAME .' '.$singlecustomer->LNAME; ?>
      </div>
       <div class="col-md-2 col-lg-2 col-sm-2" style="float:left">
        Address:
      </div>
      <div class="col-md-8 col-lg-10 col-sm-3" style="float:left">
        <?php echo $singlecustomer->CUSHOMENUM . ' ' . $singlecustomer->STREETADD . ' ' .$singlecustomer->BRGYADD . ' ' . $singlecustomer->CITYADD . ' ' .$singlecustomer->PROVINCE . ' ' .$singlecustomer->COUNTRY; ?>
      </div>
    </div>

    <div class="col-md-6 pull-right">
    <div class="col-md-10 col-lg-12 col-sm-8">
    <input type="hidden" value="<?php echo $res->AUTO; ?>" id="ORDEREDNUM" name="ORDEREDNUM">
      Order Number :<?php echo $res->AUTO; ?>
    </div>
    </div>
 </div>
      <div class="table-responsive cart_info"> 
 
              <table class="table table-condensed" id="table">
                <thead >
                <tr class="cart_menu"> 
                  <th style="width:12%; align:center; ">Product</th>
                  <th >Description</th>
                  <th style="width:15%; align:center; ">Quantity</th>
                  <th style="width:15%; align:center; ">Price</th>
                  <th style="width:15%; align:center; ">Total</th>
                  </tr>
                </thead>
                <tbody>    
                       
              <?php

              $tot = 0;
                if (!empty($_SESSION['gcCart'])){ 
                      $count_cart = @count($_SESSION['gcCart']);
                      for ($i=0; $i < $count_cart  ; $i++) { 

                      $query = "SELECT * FROM `tblpromopro` pr , `tblproduct` p , `tblcategory` c
                           WHERE pr.`PROID`=p.`PROID` AND  p.`CATEGID` = c.`CATEGID`  and p.PROID='".$_SESSION['gcCart'][$i]['productid']."'";
                        $mydb->setQuery($query);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result){ 
              ?>

                         <tr>
                         <!-- <td></td> -->
                          <td><img src="admin/products/<?php echo $result->IMAGES ?>"  width="50px" height="50px"></td>
                          <td><?php echo $result->PRODESC ; ?></td>
                          <td align="center"><?php echo $_SESSION['gcCart'][$i]['qty']; ?></td>
                          <td>&#8369 <?php echo  $result->PRODISPRICE ?></td>
                          <td>&#8369 <output><?php echo $_SESSION['gcCart'][$i]['price']?></output></td>
                        </tr>
              <?php
              $tot +=$_SESSION['gcCart'][$i]['price'];
                        }

                      }
                }
              ?>
            

                </tbody>
                
              </table>  
                <div class="  pull-right">
                  <p align="right">
                  <div > Total Price :   &#8369 <span id="sum">0.00</span></div>
                   <div > Delivery Fee : &#8369 <span id="fee">0.00</span></div>
                   <div> Overall Price : &#8369 <span id="overall"><?php echo $tot ;?></span></div>
                   <input type="hidden" name="alltot" id="alltot" value="<?php echo $tot ;?>"/>
                  </p>  
                </div>
 
      </div>
    </div>
  </section>
  
 <section id="do_action">
    <div class="container">
      <div class="heading">
        <h3>What would you like to do next?</h3>
      </div>
      <div class="row">
         <div class="row">
                   <div class="col-md-7">
              <div class="form-group" style="margin-left: 50px">
                  <label> Payment Method : </label> 
                  <div class="radio" >
                      <label >
                          <input type="radio"  class="paymethod" name="paymethod" id="deliveryfee" value="Cash on Delivery" checked="true" data-toggle="collapse"  data-parent="#accordion" data-target="#collapseOne" >Cash on Delivery 
                      </label>
                  </div> 
              </div>  
              <div class="form-group" style="margin-left: 50px">
              <label> Shipping Option </label> 
                  <div class="radio" >
                      <label >
                          <input type="radio"  class="shippingoption" name="shippingoption" id="shippingoption" value="Shipping Option" checked="true" data-toggle="collapse"  data-parent="#accordion" data-target="#collapseOne" >J&T Express
                      </label>
                  </div> 
              </div>

                        <div class="panel"> 
                                <div class="panel-body">
                                    <div class="form-group ">
                                      <label>Address where to deliver</label>

                                    
                                        <div class="col-md-12">
                                          <label class="col-md-4 control-label" for=
                                          "PLACE">Place(Brgy/City):</label>

                                          <div class="col-md-8">
                                           <select class="form-control paymethod" name="PLACE" id="PLACE" onchange="validatedate()"> 
                                           <option value="0" >Select</option>
                                              <?php 
                                            $query = "SELECT * FROM `tblsetting` ";
                                            $mydb->setQuery($query);
                                            $cur = $mydb->loadResultList();

                                            foreach ($cur as $result) {  
                                              echo '<option value='.$result->DELPRICE.'>'.$result->BRGY.' '.$result->PLACE.' </option>';
                                            }
                                            ?>
                                          </select>
                                          </div>
                                        </div>  
                                      
                                    </div>
    
                                </div>
                            </div> 
      
                        <input type="hidden"  placeholder="HH-MM-AM/PM"  id="CLAIMEDDATE" name="CLAIMEDDATE" value="<?php echo date('y-m-d h:i:s') ?>"  class="form-control"/>

                   </div>  
    
             
         
              </div>
<br/>
              <div class="row">
                <div class="col-md-6">
                    <a href="index.php?q=cart" class="btn btn-default pull-left"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;<strong>View Cart</strong></a>
                   </div>
                  <div class="col-md-6">
                      <button type="submit" class="btn btn-pup  pull-right " name="btn" id="btn" onclick="return validatedate();"   /> Submit Order <span class="glyphicon glyphicon-chevron-right"></span></button> 
                </div>  
              </div>
             
      </div>
    </div>
  </section><!--/#do_action-->
</form>
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
  // Function to update the delivery fee and overall price
  function updateDeliveryFee() {
    // Get the selected delivery place value
    var deliveryPlace = $('#PLACE').val();

    // Update the delivery fee on the page
    $('#fee').text(deliveryPlace);

    // Update the overall price by adding the delivery fee
    var total = parseFloat($('#sum').text());
    var overall = total + parseFloat(deliveryPlace);
    $('#overall').text(overall.toFixed(2));
    $('#alltot').val(overall.toFixed(2));
  }

  // Attach the function to the change event of the delivery place select element
  $('#PLACE').change(function() {
    updateDeliveryFee();
  });

  // Function to validate the form before submission
  function validatedate() {
    // Add your validation logic here

    // Example: Check if the delivery place is selected
    if ($('#PLACE').val() == '0') {
      alert('Please select a delivery place.');
      return false;
    }

    // Add more validation as needed

    // If all validations pass, return true
    return true;
  }

  // Function to calculate and update the total price
  function updateTotalPrice() {
    var total = 0;

    // Iterate through table rows and sum up the total price
    $('#table tbody tr').each(function() {
      var totalPrice = parseFloat($(this).find('td:eq(4) output').text());
      total += totalPrice;
    });

    // Update the total price on the page
    $('#sum').text(total.toFixed(2));
    $('#overall').text(total.toFixed(2));
    $('#alltot').val(total.toFixed(2));
  }

  // Call the function on page load
  $(document).ready(function() {
    updateTotalPrice();
    updateDeliveryFee(); // Call this to initialize the delivery fee
  });
</script>
