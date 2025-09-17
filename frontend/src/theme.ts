import { createTheme } from "@mui/material/styles";

const theme = createTheme({
    palette: {
        mode: "dark",
        primary: { main: "#7CFF00" },
        background: {
            default: "#1f2e0e",
            paper: "#0b0f10",
        },
        text: {
            primary: "#eaeaea",
            secondary: "#9ea5ab",
        },
    },
    typography: {
        fontFamily: "Montserrat, sans-serif",
        h2: { fontWeight: 700 },
    },
});

export default theme;
