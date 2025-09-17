import { useState, useEffect } from "react";

interface TypewriterOptions {
    words: string[];
    loop?: boolean;
    typingSpeed?: number;
    deletingSpeed?: number;
    delayBetween?: number;
}

export default function useTypewriter({
    words,
    loop = true,
    typingSpeed = 100,
    deletingSpeed = 50,
    delayBetween = 2000,
}: TypewriterOptions) {
    const [index, setIndex] = useState(0); // word index
    const [subIndex, setSubIndex] = useState(0); // letter index
    const [deleting, setDeleting] = useState(false);
    const [blink, setBlink] = useState(true);

    useEffect(() => {
        if (index >= words.length) {
            if (loop) {
                setIndex(0);
            } else {
                return;
            }
        }

        if (subIndex === words[index].length + 1 && !deleting) {
            setTimeout(() => setDeleting(true), delayBetween);
            return;
        }

        if (subIndex === 0 && deleting) {
            setDeleting(false);
            setIndex((prev) => (prev + 1) % words.length);
            return;
        }

        const timeout = setTimeout(() => {
            setSubIndex((prev) => prev + (deleting ? -1 : 1));
        }, deleting ? deletingSpeed : typingSpeed);

        return () => clearTimeout(timeout);
    }, [subIndex, index, deleting, words, loop, typingSpeed, deletingSpeed, delayBetween]);

    // cursor blink
    useEffect(() => {
        const blinkInterval = setInterval(() => {
            setBlink((prev) => !prev);
        }, 500);
        return () => clearInterval(blinkInterval);
    }, []);

    return {
        text: words[index].substring(0, subIndex),
        cursor: blink ? "|" : " ",
    };
}
