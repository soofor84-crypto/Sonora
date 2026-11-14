// Reproductor SIMULADO: no hay audio; un temporizador avanza el progreso.
const pistas = window.pistas ?? [];
let i = 0; // pista actual
let t = 0; // segundos transcurridos
let temporizador = null;

const $ = (sel) => document.querySelector(sel);
const fmt = (s) =>
    `${String(Math.floor(s / 60)).padStart(2, "0")}:${String(s % 60).padStart(2, "0")}`;

function pintar() {
    const p = pistas[i];
    if (!p) return;
    if ($("#titulo")) $("#titulo").textContent = p.titulo;
    if ($("#artista")) $("#artista").textContent = p.artista;
    if ($("#tiempo")) $("#tiempo").textContent = fmt(t);
    if ($("#duracion")) $("#duracion").textContent = fmt(p.dur);
    const pct = Math.round((t / p.dur) * 100);
    if ($("#relleno")) $("#relleno").style.width = `${pct}%`;
    if ($("#barra")) $("#barra").setAttribute("aria-valuenow", pct);
    document.querySelectorAll("[data-pista]").forEach((fila) => {
        if (Number(fila.dataset.pista) === i)
            fila.setAttribute("aria-current", "true");
        else fila.removeAttribute("aria-current");
    });
}

function reproduciendo() {
    return temporizador !== null;
}

function pintarBoton() {
    const activo = reproduciendo();
    $("#icono-play")?.classList.toggle("hidden", activo);
    $("#icono-pausa")?.classList.toggle("hidden", !activo);
    $('[data-accion="alternar"]')?.setAttribute(
        "aria-label",
        activo ? "Pausar" : "Reproducir",
    );
}

function reproducir() {
    if (!pistas.length) return;
    clearInterval(temporizador);
    temporizador = setInterval(() => {
        t++;
        if (t >= pistas[i].dur) {
            cambiar(i + 1);
            return;
        }
        pintar();
    }, 1000);
    pintarBoton();
}

function pausar() {
    clearInterval(temporizador);
    temporizador = null;
    pintarBoton();
}

function cambiar(nueva) {
    if (!pistas.length) return;
    i = (nueva + pistas.length) % pistas.length;
    t = 0;
    pintar();
}

document.addEventListener("click", (e) => {
    const accion = e.target.closest("[data-accion]")?.dataset.accion;
    if (accion === "alternar") reproduciendo() ? pausar() : reproducir();
    if (accion === "siguiente") cambiar(i + 1);
    if (accion === "anterior") cambiar(i - 1);
    const fila = e.target.closest("[data-pista]");
    if (fila) {
        cambiar(Number(fila.dataset.pista));
        reproducir();
    }
});

// Interactividad con flechas del teclado (adelantar/retroceder 5 segundos)
document.addEventListener("keydown", (e) => {
    if (e.target.tagName === "INPUT") return;
    const p = pistas[i];
    if (!p) return;

    if (e.key === "ArrowRight") {
        t = Math.min(t + 5, p.dur);
        pintar();
    } else if (e.key === "ArrowLeft") {
        t = Math.max(t - 5, 0);
        pintar();
    }
});

// Tema claro/oscuro, recordado en el navegador
const raiz = document.documentElement;
try {
    raiz.dataset.theme = localStorage.getItem("tema") ?? "dark";
} catch (_) {}
$("#tema")?.addEventListener("click", () => {
    raiz.dataset.theme = raiz.dataset.theme === "dark" ? "light" : "dark";
    try {
        localStorage.setItem("tema", raiz.dataset.theme);
    } catch (_) {}
});

pintar();
