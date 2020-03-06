export const pagination = (c, m) => {
    let delta = 2,
        range = [],
        rangeWithDots = [],
        l;

    range.push(1);
    for (let i = c - delta; i <= c + delta; i++) {
        if (i < m && i > 1) {
            range.push(i);
        }
    }
    if (m > 1) {
        range.push(m);
    }

    range.map(val => {
        if (l) {
            if (val - l === 2) {
                rangeWithDots.push(l + 1);
            } else if (val - l !== 1) {
                rangeWithDots.push('...');
            }
        }
        rangeWithDots.push(val);
        l = val;
    });
    return rangeWithDots;
};
