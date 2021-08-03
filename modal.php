<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <title>UOM | Freeztek | Accounts</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link id="color" rel="stylesheet" href="./assets/css/color-1.css" media="screen">
    <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css"> 
</head>

<body>
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include('./include/topbar.php'); ?>
        <div class="page-body-wrapper">
            <?php include('./include/left-sidebar.php'); ?>
            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3> UOM </h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">UOM</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-7">
                            <?php if (isset($_SESSION['itemSuccess'])) { ?>
                                <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                    <p> <?php echo $_SESSION['itemSuccess']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                            <?php }
                            unset($_SESSION['itemSuccess']);
                            if (isset($_SESSION['itemError'])) { ?>
                                <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                                    <p> <?php echo $_SESSION['itemError']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                            <?php }
                            unset($_SESSION['itemError']); ?>
                        </div>
                        <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>Varying modal content</h5>
                  </div>
                  <div class="card-body btn-showcase">
                  <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-name="@mdo" data-uomid="@mdo" >Open modal for @mdo</button>
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">New message</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                          </div>
                          <div class="modal-body">
                            <form>
                              <div class="mb-3">
                                <label class="col-form-label" for="recipient-name">Recipient:</label>
                                <input class="form-control" type="text"  >
                              </div>
                              <div class="mb-3">
                                <label class="col-form-label" for="message-text">Message:</label>
                                <textarea class="form-control" id="message-text"></textarea>
                              </div>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" data-bs-original-title="" title="">Close</button>
                            <button class="btn btn-primary" type="button" data-bs-original-title="" title="">Send message</button>
                          </div>
                        </div>
                      </div>
                    </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 m-b-30">
                                            <a href="./item-group.php?platform=<?php echo RandomString(30) ?>&action=add"><button class="btn btn-primary f-right" type="button">Create New Store Room</button> </a>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                 
                                        <div class="table-responsive">
                                            <table class="display payment-table" id="">
                                                <thead>
                                                    <tr>
                                                        <th>QR Code</th>
                                                        <th>Group Name</th>
                                                        <th>Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $storeqrUrl = "./assets/qr/item-group/";
                                                    $query = mysqli_query($dbconnection, "SELECT * FROM `ft_item_group`");
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $id = $row['group_id'];
                                                        $storeqr = $row['group_qr'];
                                                        $storeName = $row['group_name'];
                                                    ?>
                                                        <tr>
                                                            <td><img src="<?php echo $storeqrUrl . $storeqr; ?>" alt=""></td>
                                                            <td> <?php echo $storeName;  ?></td> 
                                                            <td>
                                                                <a href="./item-group.php?platform=<?php echo randomString(45); ?>&action=edit&fieldid=<?php echo passwordEncryption($id) ?>" class="btn btn-primary btn-xs" type="button">Edit</a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('./include/footer.php'); ?>
        </div>
    </div>
    <script src="./assets/js/jquery-3.5.1.min.js"></script>
    <script src="./assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="./assets/js/icons/feather-icon/feather-icon.js"></script>
    <script src="./assets/js/scrollbar/simplebar.js"></script>
    <script src="./assets/js/scrollbar/custom.js"></script>
    <script src="./assets/js/config.js"></script> 
    <script src="./assets/js/sidebar-menu.js"></script>
    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="./assets/js/datatable/datatables/datatable.custom.js"></script> 
</body>
<script>
    $('#exampleModal').on('shown.bs.modal', function () {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var name = button.data('-bs-name') // Extract info from data-* attributes
        var id = button.data('uomid') // Extract info from data-* attributes
        console.log(button.attr("data-name"));
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this) 
  modal.find('.modal-body input').val(name)
//   modal.find('.modal-body input["hidden"]').val(id)
});

</script>
</html>