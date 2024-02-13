import helper from "./helper";
import resolveConfig from "tailwindcss/resolveConfig";
import tailwindConfig from "tailwind-config";
import flatten from "flat";

const twConfig = resolveConfig(tailwindConfig);
const colors = twConfig.theme?.colors;

function getColor(colorKey, opacity = 1) {
    const flattenColors = flatten(colors);

    if (flattenColors[colorKey].search("var") === -1) {
        return `rgb(${helper.toRGB(flattenColors[colorKey])} / ${opacity})`;
    } else {
        const cssVariableName = `--color-${
            flattenColors[colorKey].split("--color-")[1].split(")")[0]
        }`;
        return `rgb(${getComputedStyle(document.body).getPropertyValue(
            cssVariableName
        )} / ${opacity})`;
    }
}

window.getColor = getColor;

export { getColor };
