<?php  
$start = microtime(true);
$X = 'Lalisa Manoban';
$Y = 'Біографія';

$pages = [
    ['file'=>'index.php?id=1','title'=>'Lalisa Manoban (BlackPink)'],
    ['file'=>'page2.php','title'=>'Збережені об’єкти'],
    ['file'=>'page2.php?id=2','title'=>'Kai (Exo)'],
    ['file'=>'page3.php?id=3','title'=>'Jimin (BTS)'],
    ['file'=>'page4.php?id=4','title'=>'Jisoo (BlackPink)'],
    ['file'=>'page5.php?id=5','title'=>'Felix (Stray Kids)'],
];

$img = 'img/Lisa.jfif';
$aimg ='img/instagram.png';
$alink = 'https://www.instagram.com/lalalalisa_m/';
$maplink = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7960469.022998586!2d101.490104!3d13.038996899999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304d8df747424db1%3A0x9ed72c880757e802!2z0KLQsNC40LvQsNC90LQ!5e0!3m2!1sru!2sua!4v1758467173592!5m2!1suk!2sua';

$ol_list = [
    "Сольні треки в складі гурту: “Lie”, “Serendipity” та “Filter”.",
    "Освіта та танці: Чімін навчався у Busan High School of Arts і спеціалізувався на сучасному танці."
];

$block_6_text = [
    "Лаліса Манобан народилася 27 березня 1997 року в Бангкоку, Таїланд. З дитинства захоплювалася музикою та танцями.",
    "У 2016 році дебютувала в BLACKPINK. У 2021 році випустила сольний альбом «LALISA», який отримав світове визнання."
];
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="img/icon.png" type="image/png">
    <title><?= htmlspecialchars($X) ?></title>
    <style>
    .collapse-btn {
      background-color: #7ed9b8;
      color: #222;
      cursor: pointer;
      padding: 10px;
      width: 100%;
      border: none;
      text-align: left;
      font-size: 16px;
      margin-top: 5px;
      border-radius: 6px;
    }
    .collapse-content {
      padding: 10px;
      display: none;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 5px;
    }
    </style>
</head>
<body>

<header class="header">
    <h1><?= htmlspecialchars($X) ?></h1>
</header>

<div class="container">
    <div class="container-wrapper">
        <h4>Меню</h4>
        <ul>
            <?php foreach($pages as $i => $p): ?>
                <?php $href = $p['file']; $label = $p['title']; ?>
                <li>
                    <a href="<?= $href ?>" class="<?= ($_GET['id']??1)==($i+1) ? 'active' : '' ?>">
                        <?= htmlspecialchars($label) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="container-blocks">
        <div class="block-3-4-5">

    
            <div class="block-3">
                <h2>Список об’єктів (Collapse)</h2>
                <div id="collapse-container"></div>
                <p><a href="add.html">Додати новий об’єкт</a></p>
            </div>

        
            <div class="block-4-5">
                <div class="block-4">
                    <iframe src="<?= htmlspecialchars($maplink) ?>" width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy"></iframe>
                </div>

           
                <div class="block-5">
                    <h2>Цікаві факти:</h2>
                    <ol>
                        <?php foreach($ol_list as $item): ?>
                            <li><?= htmlspecialchars($item) ?></li>
                        <?php endforeach; ?>
                    </ol>
                    <a href="<?= htmlspecialchars($alink) ?>"><img class="aimg" src="<?= htmlspecialchars($aimg) ?>" alt="Instagram"></a>
                </div>
            </div>
        </div>

        
        <div class="block-6">
            <h2><?= htmlspecialchars($Y) ?></h2>
            <?php foreach($block_6_text as $paragraph): ?>
                <p><?= $paragraph ?></p>
            <?php endforeach; ?>
        </div>
    </div> 
</div>

<script>
function loadCollapseObjects() {
  fetch('get_objects.php')
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById('collapse-container');
      container.innerHTML = '';
      data.forEach(obj => {
        const btn = document.createElement('button');
        btn.className = 'collapse-btn';
        btn.textContent = obj.title;

        const div = document.createElement('div');
        div.className = 'collapse-content';
        div.textContent = obj.content;

        btn.addEventListener('click', () => {
          div.style.display = div.style.display === 'block' ? 'none' : 'block';
        });

        container.appendChild(btn);
        container.appendChild(div);
      });
    })
    .catch(err => console.error('Помилка:', err));
}

loadCollapseObjects();
setInterval(loadCollapseObjects, 5000);
</script>

</body>
</html>
