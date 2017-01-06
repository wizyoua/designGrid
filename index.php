<!DOCTYPE html>
<html>
<head>
	<title>Final Cart</title>

  <!-- LOAD CSS -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <!-- LOAD JS FILES -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.0/angular.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular-animate.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular-sanitize.js"></script>
    <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.4.0.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/ngCart.js"></script>
  <script type="text/javascript" src="js/dropdownLayer.js"></script>
  <script type="text/javascript" src="js/load.js"></script>



  <script type="text/javascript">
    
    //Initiate the Angular Module
    var app = angular.module("order", ['ngCart', 'ui.bootstrap']);
    
    //Controller for Implementing data into Cart
    app.controller("ShopCartCtrl",['$scope', 'ngCart','$http',  function($scope, ngCart, $http ) {

         $scope.oneAtATime = true;

            $scope.groups = [
              {
                title: 'Dynamic Group Header - 1',
                content: 'Dynamic Group Body - 1'
              },
              {
                title: 'Dynamic Group Header - 2',
                content: 'Dynamic Group Body - 2'
              }
            ];


        $scope.preMade = null;

        $http.get('use.json').then(function(response){
          $scope.preMade = response.data;
           $scope.showAction = function (id){
                //Check if user selected more than 1 meat, run a for loop until we reach ingredients -> and seperate by meat only since that is what will be charged. 
                  var preData = ngCart['$cart']['items'];
                  console.log(preData);

                  //Begin to loop items in cart to check for multiples
                  for (var j = 0; j < preData.length; j++){
                    //remove console
                    var initialLayer = preData[j];
                    //console.log(initialLayer);
                    //remove console
                    var dataLayer = preData[j]._data;
                    //console.log(dataLayer);
                    //begin for looping through data array in cart
                    for (var k = 0; k < dataLayer.length; k++){
                      //general variable - add category in which you want to loop
                      var meatLayer = dataLayer[k];
                      //begin accessing individual meats
                      if(meatLayer.Meats){
                        var indMeat = meatLayer.Meats.Type;
                        //console.log(meatLayer.Meats.Type);
                        for(var l = 0; l < indMeat.length; l++){
                          var indMeatTrue = indMeat[l].Double;
                          console.log(indMeatTrue);
                        }                        
                      }
                    }
                  }
                  //if yes, add price of single meat td data
                  


                  // Grab data after user presses order
                  var postData = JSON.stringify(ngCart['$cart']['items']);
                  
                  
                  // Make Data usable with php form
                  $scope.postData = postData;
                  //data testing -rm
                  //console.log($scope.postData);
          }
        });//end GET

      ngCart.setTaxRate(7.5);
      ngCart.setShipping(0.00);
    }]);

  </script>
</head>
<body ng-app="order">

	<!-- Navigation -->
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
      <div class="container">
          <div class="navbar-header">
              <p class="navbar-p" >Pick up Store: </p>
              <span class="navbar-store">Store</span>
          </div>
          <div class=" navbar-header pull-right">
              <p class="navbar-p">Cart Total: <span><ngcart-summary></ngcart-summary></span></p>
              <button class="btn btn navbar-btn navbar-checkoutBtn" data-toggle="modal" data-target="#modaltest" ng-click="updateFinalOrder(postData)">CHECKOUT ></button>
              <!-- Script for Displaying total order summary -->
              <script type="text/ng-template" id="template/ngCart/summary.html">
                <span class="">{{ ngCart.getTotalItems() }}
                  <ng-pluralize count="ngCart.getTotalItems()" when="{1: 'item', 'other':'items'}"></ng-pluralize>
                  {{ ngCart.totalCost() | currency }}
                </span>
              </script>
          </div>
      </div>
  </nav>
  <!-- End Navigation -->

  

  <!-- Body -->
  <div class="container" ng-controller="ShopCartCtrl">
  <!--   <div class="body-logo" >
            <img src="images/logo.png" class="body-logo-img">    
    </div> -->
    <div class="body-order-div">
      <span class="body-order-text"> Order For Pickup </span>
    </div>

    <div class="row">
      <div class=" persons js-dropdown-items"  >
        <div  class="person js-dropdown-item "  ng-repeat="sandwhich in preMade" >
          <img class="img-responsive" src="https://www.vhhockey.com/wp-content/uploads/2013/05/placeholder3-1024x768.png" style="width: 100%;" alt="Frazier Farms sandwiches {{sandwhich.Name}}">
          <h3 style="color: #8a6b24; text-align: center;">{{sandwhich.Name}}</h3>
          <p>Sandwhich Description that includes current items.</p>
          <h3 style="color: #8a6b24; text-align: center;">{{sandwhich.Price}}</h3>
          <div class="top">
            <h4 style="padding: 0px; margin: 0px; margin-top: 3px;">Customize Sandwhich</h4>
            <div class="arrow-down"></div>
          </div>
          <div ng-repeat="sandwhichCategory in sandwhich.Ingredients">
                    <div ng-repeat="sandwhichSpecific in sandwhichCategory.Bread.Type">
                      <pre>{{sandwhichSpecific}}</pre>

                     <label for="{{sandwhichSpecific.Name}}">{{sandwhichSpecific.Name}}<input name="{{sandwhichSpecific.Name}}" ng-model="sandwhichSpecific.Present" ng-bind="sandwhichSpecific.Present" ng-click="updateSelection($index, sandwhichCategory.Bread.Type)" type="checkbox" /></label>
                    </div>
                    <div ng-repeat="sandwhichSpecific in sandwhichCategory.Meats.Type">
                      <pre>{{sandwhichSpecific}}</pre>
                    </div>
                    <div ng-repeat="sandwhichSpecific in sandwhichCategory.Veggies.Type">
                      <pre>{{sandwhichSpecific}}</pre>
                    </div>
                    <div ng-repeat="sandwhichSpecific in sandwhichCategory.Condiments.Type">
                      <pre>{{sandwhichSpecific}}</pre>
                    </div>
                  </div>  
          <div class="js-description {{$index}}">
            <div class="container" style="width: 100% !important">
              <div class="row">
                <div class="col-md-6">
                  <div ng-repeat="sandwhichCategory in sandwhich.Ingredients">
                    <div ng-repeat="sandwhichSpecific in sandwhichCategory.Bread.Type">
                      <pre>{{sandwhichSpecific}}</pre>

                     <label for="{{sandwhichSpecific.Name}}">{{sandwhichSpecific.Name}}<input name="{{sandwhichSpecific.Name}}" ng-model="sandwhichSpecific.Present" ng-bind="sandwhichSpecific.Present" ng-click="updateSelection($index, sandwhichCategory.Bread.Type)" type="checkbox" /></label>
                    </div>
                    <div ng-repeat="sandwhichSpecific in sandwhichCategory.Meats.Type">
                      <pre>{{sandwhichSpecific}}</pre>
                    </div>
                    <div ng-repeat="sandwhichSpecific in sandwhichCategory.Veggies.Type">
                      <pre>{{sandwhichSpecific}}</pre>
                    </div>
                    <div ng-repeat="sandwhichSpecific in sandwhichCategory.Condiments.Type">
                      <pre>{{sandwhichSpecific}}</pre>
                    </div>
                  </div>  
                </div>
                <div class="col-md-6">
                  <!-- Show Sand which Build -->
                    <div>
                      <h3>Your Sandwhich Details</h3>
                      <div  ng-repeat="sandwhichCategory in sandwhich.Ingredients">
                      <hr>
                        <span ng-repeat="customWhichCategoryFinal in sandwhichCategory.Bread.Type | filter: {Present: true}"> 
                        {{customWhichCategoryFinal}}
                        </span>
                        <span ng-repeat="customWhichCategoryFinal in sandwhichCategory.Meats.Type | filter: {Present: true}"> 
                        {{customWhichCategoryFinal}}
                        </span>
                        <span ng-repeat="customWhichCategoryFinal in sandwhichCategory.Veggies.Type | filter: {Present: true}"> 
                        {{customWhichCategoryFinal}}
                        </span>
                        <span ng-repeat="customWhichCategoryFinal in sandwhichCategory.Condiments.Type | filter: {Present: true}">
                        {{customWhichCategoryFinal}}
                        </span>
                       <!--  <span ng-repeat="customWhichCategoryFinal in sandwhichCategory.Meats.Type"">
                          Meats:
                          <p ng-repeat="customWhichSingle in customWhichCategoryFinal | filter: {'Present': true}: true">
                             {{customWhichSingle.Name}}<span ng-repeat="customWhichSingle in customWhichCategoryFinal | filter: {'Double': true}: true "> + Double</span>
                              </p>
                        </span>
                        <span ng-repeat="customWhichCategoryFinal in sandwhichCategory.Veggies.Type">
                          Veggies: 
                          <p ng-repeat="customWhichSingle in customWhichCategoryFinal | filter: {'Present': true}: true">
                          {{customWhichSingle.Name}}</p>
                        </span>
                        <span ng-repeat="customWhichCategoryFinal in sandwhichCategory.Condiments.Type">
                          Condiments:
                          <p ng-repeat="customWhichSingle in customWhichCategoryFinal | filter: {'Present': true}: true">
                          {{customWhichSingle.Name}}</p>
                        </span> -->
                      </div>
                    </div>
                </div>
              </div>
            </div>
        
          </div>
          <ngcart-addtocart id="{{sandwhich.+$index+1}}" name="{{sandwhich.Name}}"  data="sandwhich.Ingredients" price="{{sandwhich.Price}}" quantity="1" quantity-max="5" ng-click="showAction(sandwhich.+$index+1)">Add to Cart</ngcart-addtocart>  
        </div>
      </div>
  	</div>

  </div>
  <!-- End Body -->






<!-- SCript for Displaying total order summary -->
<script type="text/ng-template" id="template/ngCart/cart.html">
<div class="alert alert-warning" role="alert" ng-show="ngCart.getTotalItems() === 0">
  Your cart is empty
</div>
<div class="table-responsive col-lg-12" ng-show="ngCart.getTotalItems() > 0">
  <table class="table table-striped ngCart cart">
    <thead>
      <tr>
        <th></th>
        <th></th>
        <th>Quantity</th>
        <th>Amount</th>
        <th>Total</th>
      </tr>
    </thead>
    <tfoot>
      <tr ng-show="ngCart.getTax()">
        <td></td>
        <td></td>
        <td></td>
        <td>Tax ({{ ngCart.getTaxRate() }}%):</td>
        <td>{{ ngCart.getTax() | currency }}</td>
      </tr>
      <tr ng-show="ngCart.getShipping()">
        <td></td>
        <td></td>
        <td></td>
        <td>Shipping:</td>
        <td>{{ ngCart.getShipping() | currency }}</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Total:</td>
        <td>{{ ngCart.totalCost() | currency }}</td>
      </tr>
    </tfoot>
    <tbody>
      <tr ng-repeat="item in ngCart.getCart().items track by $index">
        <td><span ng-click="ngCart.removeItemById(item.getId())" class="glyphicon glyphicon-remove"></span></td>

        <td>{{ item.getName() }} <span id="#"></span></td>
        <td><!-- <span class="glyphicon glyphicon-minus" ng-class="{'disabled':item.getQuantity()==1}"
        ng-click="item.setQuantity(-1, true)"></span> -->&nbsp;&nbsp;
        {{ item.getQuantity() | number }}&nbsp;&nbsp;
        <!-- <span class="glyphicon glyphicon-plus" ng-click="item.setQuantity(1, true)"></span> --></td>
        <td>{{ item.getPrice() | currency}}</td>
        <td>{{ item.getTotal() | currency }}</td>
      </tr>
    </tbody>
  </table>
</div>
</script>

<script type="text/ng-template" id="template/ngCart/checkout.html">
<span ng-if="service=='http' || service == 'log'">
  <button class="btn btn-primary" ng-click="checkout()" ng-disabled="!ngCart.getTotalItems()" ng-transclude>Checkout</button>
</span>

</script>



</div>



<!-- Script for Adding Sandwhich info to cart -->
<script type="text/ng-template" id="template/ngCart/addtocart.html">
<div ng-hide="attrs.id">
  <a class="btn btn-lg btn-primary" ng-disabled="true" ng-transclude></a>
</div>
<div ng-show="attrs.id">
  <div>
    <span ng-show="quantityMax">
      <select name="quantity" id="quantity" ng-model="q" ng-options=" v for v in qtyOpt"></select>
    </span>
      <a class="btn btn-sm btn-primary " ng-click="ngCart.addItem(id, name, price, q, data)" ng-transclude  ></a>
  </div>
  <span ng-show="inCart()">
  <br>
  <p class="alert alert-info">This item is in your cart. <a ng-click="ngCart.removeItemById(id)" style="cursor: pointer;">Remove</a></p>
  </span>
</div>
</script>







<div class="modal fade" id="modaltest">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Finish Ordering</h4>
      </div>
      <div class="modal-body">
        <ngcart-cart></ngcart-cart>
        <!--Begin Form For User Data -->
        <form  class="simple-form" action="checkout.php" method="post">
            <label for="name"> Name: <input type="text" name="name" required/></label><br />
            <label for="email"> Email: <input type="email" name="email" required/></label><br />
            <input type="text" style="display: none;" name="information" ng-model="postData" value="postData">
            <input type="submit" value="Submit" />
          </form>
      </div>
      <div class="modal-footer">
        <ngcart-checkout service="http" settings>Checkout</ngcart-checkout>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



</body>
<div class="se-pre-con">
  <div class="loader">
  <div class="dot"></div>
  <div class="dot"></div>
  <div class="dot"></div>
  <div class="dot"></div>
  <div class="dot"></div>
</div>
</div>
</html>