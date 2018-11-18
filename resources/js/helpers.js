export function str_after(str, value) {
    const index = str.indexOf(value);

    if (index === -1) {
        return;
    }

    return str.substr(index+1);
}

export function str_before(str, value) {
    const index = str.indexOf(value);

    if (index === -1) {
        return;
    }

    return str.substr(0, index);
}
