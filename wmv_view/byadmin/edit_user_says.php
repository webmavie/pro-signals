<?
if (is_numeric($_GET['id'])) {
    $find=$db->get_onerow('user_says', array('id' => $_GET['id']));
    if (empty($find['id'])) {
        $response=array('title' => 'Error', 'text' => 'Id not found!', 'status' => 'error');
        $_SESSION['flashback']=json_encode($response);
        header('Location: '.base_url('byadmin/user_says'));
        exit;
    }
}else {
    $response=array('title' => 'Error', 'text' => 'Id not found!', 'status' => 'error');
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/user_says'));
    exit;
}
$page='user_says';
include('_header.php'); 
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit</h1>
        <a href="<?=this_url()?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Refresh page</a>
    </div>

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <form method="POST" action="<?=action_url()?>">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">User says</h6>
                        <div class="dropdown no-arrow">
                            <button class="btn btn-success" href="#" role="button">
                                Save
                            </button>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label>Full name *</label>
                            <input required type="text" name="name" value="<?=$find['name']?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Country *</label>
                            <select name="country" class="form-control" required>
                                <option value="" disabled selected>-- Please select --</option>
                                    <? 
                                        foreach ($countries as $code => $country) {
                                            echo '<option '.($find['country']==$code?'selected':'').' value="'.$code.'">'.$country.'</option>';
                                        }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea name="text" class="form-control"><?=$find['text']?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Order</label>
                            <input required type="number" name="order" class="form-control" value="<?=$find['order']?>">
                        </div>
                        
                    </div>
                    <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">User says</h6>
                        <div class="dropdown no-arrow">
                            <button class="btn btn-success" href="#" role="button">
                                Save
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?=$find['id']?>">
                    <input type="hidden" name="form" value="edit_user_says">
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<? include('_footer.php'); ?>