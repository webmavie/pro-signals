<?php
$findUser['id']='';
if (isset($_COOKIE['login_hash'])) {
    $findUser=$db->get_onerow('users', array('login_hash' => escape_string($_COOKIE['login_hash'])));
    if (empty($findUser['id'])) {
        header('Location: '.base_url());
        exit;
    }
}else {
    header('Location: '.base_url());
    exit;
}
$findResult=$db->get_onerow('results', array('hash' => escape_string($_GET['hash'])));
if (empty($findResult['id'])) {
    header('Location: '.base_url());
    exit;
}
if ($_SESSION['loghash']!==$findResult['hash']) {
    $db->add_row('logs_actions', array('uid' => $findUser['id'], 'email' => $findUser['email'], 'page' => $findResult['title'], 'ip' => getUserIP()));
    $_SESSION['loghash']=$findResult['hash'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <style>
        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 100%;
            table-layout: fixed;
        }

        table caption {
            font-size: 1.5em;
            margin: .5em 0 .75em;
        }

        table tr {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: .35em;
        }

        table th,
        table td {
            padding: .625em;
            text-align: center;
        }

        table th {
            font-size: .85em;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        @media screen and (max-width: 600px) {
            table {
                border: 0;
            }

            table caption {
                font-size: 1.3em;
            }

            table thead {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
            }

            table tr {
                border-bottom: 3px solid #ddd;
                display: block;
                margin-bottom: .625em;
            }

            table td {
                border-bottom: 1px solid #ddd;
                display: block;
                font-size: .8em;
                text-align: right;
            }

            table td::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }

            table td:last-child {
                border-bottom: 0;
            }
        }

        /* general styling */
        body {
            font-family: "Open Sans", sans-serif;
            line-height: 1.25;
        }
    </style>
</head>

<body>
    <table>
        <caption><?=$findResult['title']?></caption>
        <thead>
            <tr>
                <?php
                $table_titles=json_decode($findResult['table_titles'], TRUE);
                    foreach ($table_titles as $ttitle) {
                        echo '<th scope="col">'.$ttitle.'</th>';
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                $getData=$db->get_allrow('result_data', array('rid' => $findResult['id']));
                foreach ($getData as $row) {
                    echo '<tr>';
                    $datas=json_decode($row['data'], TRUE);
                    foreach ($datas as $key => $data) {
                        echo '<td data-label="'.$key.'">'.$data.'</td>';
                    }
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
</body>

</html>