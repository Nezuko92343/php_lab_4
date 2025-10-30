<?php 
$start = microtime(true);
$X = 'Jimin (BTS)';
$Y = 'Біографія';

$pages = [
    ['file'=>'index.php?id=1','title'=>'Lalisa Manoban (BlackPink)'],
    ['file'=>'page2.php?id=2','title'=>'Kai (Exo)'],
    ['file'=>'page3.php?id=3','title'=>'Jimin (BTS)'],
    ['file'=>'page4.php?id=4','title'=>'Jisoo (BlackPink)'],
    ['file'=>'page5.php?id=5','title'=>'Felix (Stray Kids)'],
];

$img = 'img/jimin.jfif';
$aimg ='img/instagram.png';

$alink = 'https://www.instagram.com/j.m';
$maplink = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3313885.42629416!2d125.23235454184936!3d35.79462444248789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x356455ebcb11ba9b%3A0x91249b00ba88db4b!2z0K7QttC90LDRjyDQmtC-0YDQtdGP!5e0!3m2!1sru!2sua!4v1758469004014!5m2!1suk!2sua';

$ol_list = [
    "Освіта та танці:
Чімін навчався у Busan High School of Arts, де спеціалізувався на сучасному танці (modern dance). Його викладачі помітили талант і підштовхнули до участі в прослуховуваннях, що врешті привело до підписання контракту з Big Hit Entertainment.",
    "Сольні треки в складі гурту
В рамках BTS він виконав кілька сольних пісень: “Lie” (2016), “Serendipity” (2017) та “Filter” (2020). Вони досягали високих позицій у чартах, і “Filter” встановив рекорд за кількістю стрімів серед корейських пісень у перші 24 години після виходу."
];


$block_6_text = [
    "
Чімін (Пак Чі Мін, народився 13 жовтня 1995 року в Пусані, Південна Корея) — співак, танцюрист та автор пісень, відомий як один із вокалістів і головних танцюристів гурту BTS. Він навчався у Busan High School of Arts, де спеціалізувався на сучасному танці, що згодом визначило його сценічний стиль.",
    "У складі BTS дебютував у 2013 році та здобув світове визнання завдяки потужній харизмі, емоційному вокалу й унікальним сольним трекам, серед яких “Lie”, “Serendipity” та “Filter”. У 2023 році він розпочав успішну сольну кар’єру, випустивши альбом Face, а його сингл Like Crazy став першим корейським сольним треком, що очолив Billboard Hot 100."
];


?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
      <link rel="icon" href="img/icon.png" type="image/png">
    <title> <?= htmlspecialchars($X) ?></title>
</head>
<body>

<header class="header">
    <h1>
        <?= htmlspecialchars($X) ?>
    </h1>
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
            <img src="<?= htmlspecialchars($img) ?>" alt="Lalisa Manoban" class="photo">
            </div>
            <div class="block-4-5">
            <div class="block-4">
                <iframe 
    src="<?= htmlspecialchars($maplink) ?>" 
    width ="100%"
    height="100%"
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
</iframe>

            </div>
            <div class="block-5">
                <h2>Цікаві факти:</h2>
    <ol>
        <?php foreach($ol_list as $item): ?>
            <li><?= htmlspecialchars($item) ?></li>
        <?php endforeach; ?>
    </ol>
    <a href=" <?= htmlspecialchars($alink) ?>"><img class="aimg" src=" <?= htmlspecialchars($aimg) ?>" alt="Instagram"></a>
            </div>
            </div>
        </div>
        
        <div class="block-6">
        <h2><?= htmlspecialchars($Y) ?></h2>
            <?php foreach($block_6_text as $paragraph): ?>
        <p><?= $paragraph ?></p>
    <?php endforeach; ?>
         <button id="show-time-btn" 
        style="
            margin: 20px; 
            padding: 10px 20px; 
            cursor: pointer; 
            background-color: #a3f0d1; /* м'ятний фон */
            color: #024d31; /* темно-зелений текст для контрасту */
            border: 2px solid #7ed9b8; 
            border-radius: 8px; 
            font-size: 15px; 
            font-weight: 500; 
            box-shadow: 0 2px 6px rgba(0,0,0,0.2); 
            transition: all 0.3s ease;
        "
        onmouseover="this.style.backgroundColor='#7ed9b8'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.25)';"
        onmouseout="this.style.backgroundColor='#a3f0d1'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.2)';">
    Показати час завантаження
</button>
</div>

        </div> 
    </div>
</div>

</body>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const elements = document.querySelectorAll("h1, h2, h4, p, li");
    const page = window.location.pathname.split("/").pop();
    const startFetch = performance.now();

    // Підтягування даних з БД
    fetch("db.php?page=" + encodeURIComponent(page))
        .then(res => res.json())
        .then(data => {
            const endFetch = performance.now();
            const dbTime = endFetch - startFetch; // мс
            const serverTime = <?= round((microtime(true) - $start) * 1000, 4) ?>; // мс
            const totalTime = serverTime + dbTime;

            // Замінюємо текст елементів
            elements.forEach((el, index) => {
                if (data[index] !== undefined && data[index] !== null) {
                    el.textContent = data[index];
                }
            });

            // Кнопка показу часу
            const btn = document.getElementById("show-time-btn");
            btn.addEventListener("click", function() {
                const overlay = document.createElement("div");
                overlay.style = `
                    position:fixed; top:0; left:0; width:100%; height:100%;
                    background:rgba(0,0,0,0.5); display:flex;
                    justify-content:center; align-items:center; z-index:9999;
                `;

                const box = document.createElement("div");
                box.style = `
                    background:#fff; padding:20px; border-radius:8px;
                    box-shadow:0 0 10px rgba(0,0,0,0.3); min-width:300px;
                `;

                box.innerHTML = `
                    <h3>Час формування сторінки</h3>
                    <p>Час формування на сервері: ${serverTime.toFixed(2)} мс</p>
                    <p>Час підтягування даних із БД: ${dbTime.toFixed(2)} мс</p>
                    <p><strong>Загальний час для користувача: ${totalTime.toFixed(2)} мс</strong></p>
                    <button id="close-time">Закрити</button>
                `;

                overlay.appendChild(box);
                document.body.appendChild(overlay);

                // Закриття
                document.getElementById("close-time").addEventListener("click", function() {
                    document.body.removeChild(overlay);
                });
                overlay.addEventListener("click", function(e) {
                    if (e.target === overlay) document.body.removeChild(overlay);
                });
            });
        })
        .catch(err => {
            console.error("Помилка запиту до БД:", err);
        });

    // Редагування при кліку
    elements.forEach((el, index) => {
        el.style.cursor = "pointer";
        el.addEventListener("click", function() {
            const overlay = document.createElement("div");
            overlay.style = `
                position:fixed; top:0; left:0; width:100%; height:100%;
                background:rgba(0,0,0,0.5); display:flex;
                justify-content:center; align-items:center; z-index:9999;
            `;
            const form = document.createElement("div");
            form.style = `
                background:#fff; padding:20px; border-radius:8px;
                box-shadow:0 0 10px rgba(0,0,0,0.3); min-width:300px; max-width:600px;
            `;
            const textarea = document.createElement("textarea");
            textarea.value = el.textContent;
            textarea.style = "width:100%; height:100px; margin-bottom:10px;";

            const saveBtn = document.createElement("button");
            saveBtn.textContent = "Зберегти";
            saveBtn.style.marginRight = "10px";

            const cancelBtn = document.createElement("button");
            cancelBtn.textContent = "Скасувати";

            form.appendChild(textarea);
            form.appendChild(saveBtn);
            form.appendChild(cancelBtn);
            overlay.appendChild(form);
            document.body.appendChild(overlay);
            textarea.focus();

            saveBtn.addEventListener("click", function () {
                const newContent = textarea.value;
                fetch("db.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "page=" + encodeURIComponent(page) + "&index=" + index + "&content=" + encodeURIComponent(newContent)
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === "ok") el.textContent = newContent;
                    else alert("Помилка збереження: " + (res.message || JSON.stringify(res)));
                })
                .catch(err => alert("Помилка запиту: " + err));
                document.body.removeChild(overlay);
            });

            cancelBtn.addEventListener("click", () => document.body.removeChild(overlay));
            overlay.addEventListener("click", e => { if (e.target === overlay) document.body.removeChild(overlay); });
        });
    });
});
</script>

</html>