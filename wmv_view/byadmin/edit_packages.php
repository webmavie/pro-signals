<?
if (is_numeric($_GET['id'])) {
    $find=$db->get_onerow('packages', array('id' => $_GET['id']));
    if (empty($find['id'])) {
        $response=array('title' => 'Error', 'text' => 'Id not found!', 'status' => 'error');
        $_SESSION['flashback']=json_encode($response);
        header('Location: '.base_url('byadmin/packages'));
        exit;
    }
}else {
    $response=array('title' => 'Error', 'text' => 'Id not found!', 'status' => 'error');
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/packages'));
    exit;
}
$page='packages';
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
                        <h6 class="m-0 font-weight-bold text-primary">Packages</h6>
                        <div class="dropdown no-arrow">
                            <button class="btn btn-success" href="#" role="button">
                                Save
                            </button>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label>Language *</label>
                            <select name="lang_code" class="form-control" required>
                                <option value="" disabled selected>-- Please select --</option>
                                    <? 
                                        foreach (glob(base_dir(LANGUAGE_DIR)."*.php") as $key) {
							                $key=basename($key, '.php');
                                            echo '<option '.($find['lang_code']==$key?'selected':'').' value="'.$key.'">'.$code_to_lang[$key].'</option>';
                                        }
                                    ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Title *</label>
                            <input required type="text" name="title" value="<?=$find['title']?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Period *</label>
                            <select name="period" class="form-control" required>
                                <option <?=($find['period']=='per week'?'selected':'')?> value="per week">Per week</option>
                                <option <?=($find['period']=='per month'?'selected':'')?> value="per month">Per month</option>
                                <option <?=($find['period']=='per year'?'selected':'')?> value="per year">Per year</option>
                                <option <?=($find['period']=='lifetime'?'selected':'')?> value="lifetime">Lifetime</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Price *</label>
                            <input required type="text" name="price" value="<?=$find['price']?>" class="form-control">
                        </div>
                        <div class="form-group" style="border:1px dashed black;">
                            <label>Detalis  *</label>
                            <div id="detalis_input">
                                <?php
                                    $detalis=json_decode($find['detalis'], TRUE);
                                    foreach ($detalis as $value) {
                                        echo '<div class="row" style="margin-top:5px;">
                                            <div class="col-10">
                                                <input type="text" name="detalis[]" placeholder="Detalis area" value="'.$value.'" class="form-control"> 
                                            </div>
                                            <div class="col-2">
                                                <a onclick="$(this).parent().parent().remove();" class="form-control btn btn-danger">X</a>
                                            </div>
                                        </div>';
                                    }
                                ?>
                            </div>
                            <a onclick="return add_detalis_input();" style="margin-top:5px;" class='form-control btn btn-warning'>Add detalis</a>
                        </div>
                        <div class="form-group">
                            <label>Order</label>
                            <input required type="number" name="order" value="<?=$find['order']?>" class="form-control">
                        </div>
                        
                    </div>
                    <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Packages</h6>
                        <div class="dropdown no-arrow">
                            <button class="btn btn-success" href="#" role="button">
                                Save
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?=$find['id']?>">
                    <input type="hidden" name="form" value="edit_packages">
                </form>
            </div>
        </div>
    </div>

</div>
<script>
    function add_detalis_input() {
        $('#detalis_input').append('<div class="row" style="margin-top:5px;"><div class="col-10"><input type="text" name="detalis[]" placeholder="Detalis area" class="form-control"></div><div class="col-2"><a onclick="$(this).parent().parent().remove();" class="form-control btn btn-danger">X</a></div></div>'+"\n");
    }
</script>
<!-- /.container-fluid -->
<? include('_footer.php'); ?>