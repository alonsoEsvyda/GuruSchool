var playBtn = document.getElementById('play-btn');
var pauseBtn = document.getElementById('pause-btn');
var muteBtn = document.getElementById('mute-btn');
var unmuteBtn = document.getElementById('unmute-btn');
var stopBtn = document.getElementById('stop-btn');

playBtn.addEventListener('click', pausePlayHandler, false);
pauseBtn.addEventListener('click', pausePlayHandler, false);
muteBtn.addEventListener('click', muteUnmuteHandler, false);
unmuteBtn.addEventListener('click', muteUnmuteHandler, false);
stopBtn.addEventListener('click', stopHandler, false);

function pausePlayHandler(e) {
   if (video1.paused) {
       // Si está en pausa, reprodúzcalo
       video1.play();
        // Haga que se muestre el botón de pausa y se oculte el botón de reproducción
       $(playBtn).addClass("opacity");
       $(pauseBtn).removeClass('opacity');
   } else {
       // Si se está reproduciendo, páuselo
       video1.pause();
       // Haga que se muestre el botón de reproducción y se oculte el botón de pausa
       $(pauseBtn).addClass("opacity");
       $(playBtn).removeClass("opacity");
   }
}

function muteUnmuteHandler(e) {
   if (video1.volume == 0.0) {
       // Si está silenciado, active el sonido
       video1.volume = 1.0;
       // Haga que se muestre el botón de silencio y se oculte el botón de activación de sonido
       $(muteBtn).removeClass("opacity");
       $(unmuteBtn).addClass("opacity");
   } else {
       // Si el sonido está activado, siléncielo
       video1.volume = 0.0;
       // Haga que se muestre el botón de activación de sonido y se oculte el botón de silencio
       $(unmuteBtn).removeClass("opacity");
       $(muteBtn).addClass("opacity");
   }
}

function stopHandler(e) {
   // No hay método de detención para el vídeo en HTML5
   // Como solución, pause el vídeo
   // y establezca currentTime como 0
   video1.currentTime = 0;
   video1.pause();
   // Si está silenciado, active el sonido
   video1.volume = 1.0;
   $(playBtn).removeClass("opacity");
   $(pauseBtn).removeClass('opacity');
   $(unmuteBtn).removeClass("opacity");
   $(muteBtn).removeClass("opacity");
   // Muestre u oculte otros botones de vídeo según corresponda
}