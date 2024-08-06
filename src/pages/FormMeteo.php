<?php

function getFormMeteo() {
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="../styles/meteo.css">
    </head>
    <body>
        <section class="accordeonContainer">
        <h1>La météo dans le monde v5</h1>
        <form action="../controller/processMeteo.php" method="post">
            <button type="button" class="accordion">Choisir par Nom de ville</button>
            <div class="panel">
                <label for="cityName">Nom de ville :</label>
                <input type="text" id="cityName" name="cityName">
            </div>
            
            <button type="button" class="accordion">Choisir par ID de ville</button>
            <div class="panel">
                <label for="cityId">ID de ville :</label>
                <input type="text" id="cityId" name="cityId">
            </div>
            
            <button type="button" class="accordion">Choisir par Coordonnées GPS</button>
            <div class="panel">
                <label for="latitude">Latitude :</label>
                <input type="text" id="latitude" name="latitude">
                <br><br>
                <label for="longitude">Longitude :</label>
                <input type="text" id="longitude" name="longitude">
            </div>

            <br><br>
            <button class="button-check" type="submit">Go checker</button>
        </form>
        </section>

        <script>
    var acc = document.getElementsByClassName("accordion");
    for (var i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            var panel = this.nextElementSibling;

            // Close all other panels and reset their inputs
            for (var j = 0; j < acc.length; j++) {
                if (acc[j] !== this) {
                    acc[j].classList.remove("active");
                    acc[j].nextElementSibling.style.display = "none";
                    
                    // Reset inputs in closed panels
                    var inputs = acc[j].nextElementSibling.getElementsByTagName("input");
                    for (var k = 0; k < inputs.length; k++) {
                        inputs[k].value = "";
                    }
                }
            }

            // Toggle the clicked panel
            this.classList.toggle("active");
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>

    </body>
    </html>
    ';
}
?>
