import * as tailwindMerge from "tailwind-merge";

const { twMerge } = tailwindMerge;

document.querySelectorAll("[data-tw-merge]").forEach((el) => {
    el.setAttribute("class", twMerge(el.getAttribute("class")));
    el.removeAttribute("data-tw-merge");
});

window.twMerge = tailwindMerge;
