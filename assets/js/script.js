var currentPlaylist = Array();
var audioElement;
var mouseDown = false;

//Funkcja formatujaca duration time to przyjaznej postaci.
function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60);
    var seconds = time - (minutes * 60);

    if(seconds < 10) {
        seconds = "0" + seconds;
    }

    return minutes + ":" + seconds;
}

//Funkcja updatujaca progress bar piosenki
function updateTimeProgressBar(audio) {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

    var progress = audio.currentTime / audio.duration * 100;

    $("#playbackBar .progress").css("width", progress + "%");
}

function Audio() {
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    //Updatujemy pozostaly czas ktory zostal do wysluchania piosenki.
    this.audio.addEventListener("canplay", function() {
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    //Updatujemy progress bar dla granej piosenki
    this.audio.addEventListener("timeupdate", function() {
        if(this.duration) {
            updateTimeProgressBar(this);
        }
    });

    this.setTrack = function(track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }

    this.play = function() {
        this.audio.play();
    }

    this.pause = function() {
        this.audio.pause();
    }

    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }
}