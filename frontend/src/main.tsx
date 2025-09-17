import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter } from "react-router-dom";
import { ThemeProvider, CssBaseline } from "@mui/material";
import App from "./App";
import theme from "./theme";
import "./styles/index.css";
import { MainProvider } from "./contexts/MainContext";

ReactDOM.createRoot(document.getElementById("root")!).render(
  <React.StrictMode>
    <BrowserRouter>
      <ThemeProvider theme={theme}>
        <CssBaseline />
        <MainProvider>
          <App />
        </MainProvider>
      </ThemeProvider>
    </BrowserRouter>
  </React.StrictMode>
);
