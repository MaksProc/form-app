

export function useCapitalizeText() {
    function capitalize(text) {
        let t = String(text);
        t = t.trim();
        t = t.charAt(0).toUpperCase() + t.slice(1).toLowerCase();
        return t;
    }
    return capitalize;
}