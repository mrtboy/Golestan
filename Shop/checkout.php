<?php
$location = "/Golestan/Authentication/Login.php?from='checkout'";

include "../DBConfig.php";
include '../Authentication/UserController.php';
session_start();
$rangeValue = 0;


if(isset($_POST)) {
    if(!isset($_SESSION['userID']) && !isset($_SESSION['token'])) {
        header('Location: '.$location);
    } else {
        include '../common/header.php';
        $userController = new UserController();
        $result = $userController->getUserById($_SESSION['userID']);
        $address = $result->address;
    }

    if(isset($_POST['updateAddress'])){
        $newAddress= $_POST['newAddress'];
        $userId = $_SESSION['userID'];
        $userController->updateUserAddress($userId, $newAddress);
        $address = $newAddress;
    }

    if(isset($_POST['btnPayment'])){

        $rangeValue = 1;
    }
    if(isset($_POST['btnAddress'])){
        $rangeValue = 0;
    }
    if(isset($_POST['btnCheckout'])){
        $rangeValue = 2;
    }
}


?>


<div class="container ">
    <div class="row align-items-center" style="margin-top: 150px;">

        <div class="card col-sm-12" style="width: 18rem; margin-bottom: 10px;">
            <label for="customRange2">Checkout steps</label>
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        Address
                    </div>
                    <div class="col-sm text-center">
                        Payment
                    </div>
                    <div class="col-sm text-right">
                        Checkout
                    </div>
                </div>
            </div>

            <input type="range" class="custom-range" name="range" value=<?php echo $rangeValue?> min="0" max="2" id="customRange2" disabled>
        </div>
        <?php
            if($rangeValue == 0) {

                ?>
                <div class="card col-sm-12">
                    <form method="post">
                    <div class="card-body">
                        <h5 class="card-title">Receiver address</h5>
                        <p class="card-text"><?php print_r($address) ?></p>
                        <a href="#" class="card-link" data-toggle="modal" data-target="#exampleModal"
                           data-whatever="@mdo">Change the Address</a>
                    </div>
                    <button type="submit" name="btnPayment" class="btn btn-primary float-sm-right">Next</button>
                    </form>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New Address</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Address:</label>
                                        <textarea class="form-control" id="message-text" name="newAddress"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="updateAddress">Update Address
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
            elseif($rangeValue == 1) {
        ?>
        <div class="card col-sm-12" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Payment Method</h5>
                <div class="container">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                               value="option1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Credit Cart
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                               value="option2">
                        <label class="form-check-label" for="exampleRadios2">
                            Paypal
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3"
                               value="option3">
                        <label class="form-check-label" for="exampleRadios3">
                            Giro account
                        </label>
                    </div>
                </div>

                <!-- Button trigger modal -->
                <a href="#" class="card-link" data-toggle="modal" data-target="#exampleModalCenter">Select</a>
                <form method="post">
                    <button type="submit" name="btnCheckout" class="btn btn-primary float-sm-right">Next</button>
                    <button type="submit" name="btnAddress" class="btn btn-primary float-sm-right">previous</button>
                </form>


                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Paypal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <p style="color: green;text-align: center"></p>
                                    <div class="form-group">
                                        <label for="inputEmail">Email address</label>
                                        <input type="email" class="form-control" name="inputEmail"
                                               aria-describedby="emailHelp" placeholder="Enter email">
                                        <small id="emailHelp" class="form-text text-muted">We'll never share your email
                                            with anyone else.
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword">Password</label>
                                        <input type="password" class="form-control" name="inputPassword"
                                               placeholder="Password">
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Login to Paypal</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                <?php
            }
            elseif ($rangeValue == 2) {
                ?>
                <div class="card col-sm-12">
                    <form method="post">
                        <div class="card-body">
                            <h5 class="card-title">Purchase History</h5>
                            <p class="card-text"></p>
                        </div>
                        <button type="submit" name="btnPayment" class="btn btn-primary float-sm-right">Previous</button>
                    </form>
                </div>
                <?php
            }?>
    </div>
</div>
<?php
include '../common/footer.php';
?>
