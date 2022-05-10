<!DOCTYPE html>
<html lang='uk'>

<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Графік чергування учнів 1 класів, ЗОШ №24</title>
</head>

<body>
    <div class='main'>
        <?php
            //var_dump($_POST);
            session_start();           
            $number = 0;
            $schedule = [];
            if (! isset($_SESSION['pupils'])){
                $pupils = [
                    2 => ['Денис','Кирильчукін','1-А'],
                    3 => ['Анна','Петришина','1-Б'],
                    1 => ['Петро','Бульба','1-В'],
                    4 => ['Федір','Матюшкінс','1-Г'],
                ];
                $_SESSION['pupils'] = $pupils;//Присвоюємо учням з сесії значення учнінів якщо інформація не надійшла
            }
        
            echo "
                <form method='POST' action='index.php'>
                    <table>
                        <thead>
                            <tr>
                                <th rowspan='2'>Ім'я</th>
                                <th rowspan='2'>Прізвище</th>
                                <th rowspan='2'>Клас</th>
                                <th colspan='6'>Графік</th>
                            </tr>
                            <tr>
                                <th>Пн</th>
                                <th>Вт</th>
                                <th>Ср</th>
                                <th>Чт</th>
                                <th>Пт</th>
                                <th>Сб</th>
                            </tr>
                        </thead>
                        <tbody>
            ";
            if (isset($_POST['delete_pupil'])) {
                unset($_SESSION['pupils'][$_POST['delete_pupil']]);
                header('Location: /duty/index.php'); //перенаправляє на іншу сторінку
            }
            if (isset($_POST['name'])) {
                foreach ($_SESSION['pupils'] as $pupil => $pupilinfo){       
                    if ($pupil >= $number){ 
                        $number = $pupil + 1;
                    }                    
                }
                $_SESSION['pupils'][$number] = [ //Додаємо нового учня в сесію
                    $_POST['name'],
                    $_POST['secondname'],
                    $_POST['class'],
                ];
                header('Location: /duty/index.php'); //перенаправляє на іншу сторінку
            }       
            foreach ($_SESSION['pupils'] as $pupil => $pupilinfo){
        
                
                echo "
                    <tr>
                        <td>$pupilinfo[0]</td>
                        <td>$pupilinfo[1]</td>
                        <td>$pupilinfo[2]</td>
                ";
                if ($pupilinfo[2] == "1-А"){
                    $schedule = [1,2,3,4,5,6];
                }elseif ($pupilinfo[2] == "1-Б") {
                    $schedule = [6,5,4,3,2,1];
                }elseif ($pupilinfo[2] == "1-В") {
                    $schedule = [3,1,5,2,6,4];
                }elseif ($pupilinfo[2] == "1-Г") {
                    $schedule = [4,6,2,5,1,3];
                }
                foreach ($schedule as $hour) {
                    echo "
                        <td>$hour</td>
                    ";
                }
                echo "
                <td><button name='delete_pupil' type='submit' value='$pupil'>Видалити</button></td>
                    </tr>
                ";
                
            }
        
        
        
            echo "
                        </tbody>
                    </table>
                </form>
            ";
            echo "
                <h2>Додати учня</h2>
                <form action='index.php' method='POST'>
                    <label><input name='name' placeholder=\"ім'я\" type='text'></label>
                    <label><input name='secondname' placeholder='прізвище' type='text'></label>
                    <label class='cool-select'>
                        <select name='class' class='select'>
                            <option disabled selected value=''>Клас</option>
                            <option value='1-А'>1-А</option>
                            <option value='1-Б'>1-Б</option>
                            <option value='1-В'>1-В</option>
                            <option value='1-Г'>1-Г</option>
                        </select>
                    </label>
                    <label class='submit'><input value='Додати' type='submit'></label>
                </form>
            ";
        ?>
    </div>
</body>

</html>