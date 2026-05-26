
let slike = [
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.47.27.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.47.43.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.47.59.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.48.09.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.48.20.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.48.30.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.48.39.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.48.49.jpeg", 
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.49.00.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.49.11.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.49.21.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.49.32.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.49.41.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.49.50.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.50.00.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.50.09.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.50.20.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.50.29.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.50.37.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.50.47.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.50.57.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.51.06.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.51.20.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.51.29.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.51.37.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.51.45.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.52.01.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.52.12.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.52.21.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.52.31.jpeg",
    "../IMAGES/zaposljavanje/smjestaj/WhatsApp Image 2026-05-19 at 21.52.41.jpeg"
    
];

let trenutnaSlika = 0;

function promijeniSliku(smjer){
    const img = document.getElementById("galerijaSlika");

    img.classList.add("fade");

    setTimeout(function(){
        trenutnaSlika += smjer;

        if(trenutnaSlika >= slike.length){
            trenutnaSlika = 0;
        }

        if(trenutnaSlika < 0){
            trenutnaSlika = slike.length - 1;
        }

        img.src = slike[trenutnaSlika];

        img.classList.remove("fade");
    }, 500);
}
