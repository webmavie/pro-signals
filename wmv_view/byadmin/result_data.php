<?
if (is_numeric($_GET['id'])) {
    $find=$db->get_onerow('results', array('id' => $_GET['id']));
    if (empty($find['id'])) {
        $response=array('title' => 'Error', 'text' => 'Id not found!', 'status' => 'error');
        $_SESSION['flashback']=json_encode($response);
        header('Location: '.base_url('byadmin/results'));
        exit;
    }
}else {
    $response=array('title' => 'Error', 'text' => 'Id not found!', 'status' => 'error');
    $_SESSION['flashback']=json_encode($response);
    header('Location: '.base_url('byadmin/results'));
    exit;
}
$page='results';
include('_header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Result data (<?=$find['title']?>) </h1>
        
        <a href="<?=this_url()?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Refresh page</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?=base_url('byadmin/add_result_data?id='.$find['id'])?>" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add new</a></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatables" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <?php
                            $ttitles=json_decode($find['table_titles'], TRUE);
                                foreach ($ttitles as $ttitle) {
                                    echo '<th>'.$ttitle.'</th>';
                                }
                            ?>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $getResultdata=$db->get_allrow('result_data', array('rid' => $find['id']), 'reg_date', 'ASC');
                            foreach ($getResultdata as $key => $result_data) {
                                echo '<tr>';
                                    $datas=json_decode($result_data['data'], TRUE);
                                    foreach ($datas as $key => $data) {
                                        echo '<td>'.$data.'</td>';
                                    }
                                    echo '<td><a href="'.base_url('byadmin/edit_result_data?id='.$find['id'].'&sid='.$result_data['id']).'" class="btn btn-sm btn-primary">Edit</a><a href="'.action_url(array('act' => 'delete', 'mode' => 'result_data', 'id' => $result_data['id'], 'rid' => $find['id'])).'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a></td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<? include('_footer.php'); ?>