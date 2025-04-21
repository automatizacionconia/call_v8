export const periodos = getNumbers(2020, new Date().getFullYear() + 1);

function getNumbers(start, stop) {
    return new Array(stop - start).fill(start).map((n, i) => n + i);
}

export const periodoActual = parseInt(new Date().getFullYear());