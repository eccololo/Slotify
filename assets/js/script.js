var currentPlaylist = Array();
var shufflePlaylist = Array();
var tempPlaylist = Array();
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;

function openPage(url) {

    if(url.indexOf("?") == -1) {
        url = url + "?";
    }

    var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    $("#mainContent").load(encodedUrl);
}

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

//Funkcja updatujaca progress bar glosnosci piosenki
function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

function Audio() {
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    //Kiedy piosenka dojdzie do konca powinna sie zacza inna.
    this.audio.addEventListener("ended", function() {
        nextSong();
    });

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

    //Updatujemy volume bar dla granej piosenki jesli zmieniamy jej glosnosc
    this.audio.addEventListener("volumechange", function() {
        updateVolumeProgressBar(this);
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