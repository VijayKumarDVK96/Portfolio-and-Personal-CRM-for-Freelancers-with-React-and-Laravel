export type HeroDTO = {
    greeting: string;
    name: string;
    roles: string[];
    description: string;
};

export async function fetchHero(): Promise<HeroDTO> {
    // Replace URL with your backend endpoint
    const res = await fetch("/api/hero"); // or your API
    if (!res.ok) {
        // fallback to default
        return {
            greeting: "Hello, I'm",
            name: "Dipak Mourya",
            roles: ["Senior Software Developer"],
            description: "Passionate about creating exceptional web experiences...",
        };
    }
    return res.json();
}
