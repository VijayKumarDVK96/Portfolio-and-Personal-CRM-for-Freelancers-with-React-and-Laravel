import { useState } from "react";
import { AppBar, Toolbar, Typography, Button, IconButton, Drawer, List, ListItem, ListItemText, Box } from "@mui/material";
import MenuIcon from "@mui/icons-material/Menu";

const sections = ["Home", "About", "Specializations", "Resume", "Skills", "Projects", "Certifications & Awards", "Contact"];

export default function NavBar() {
    const [mobileOpen, setMobileOpen] = useState(false);
    const [activeSection, setActiveSection] = useState("Home");

    const handleDrawerToggle = () => setMobileOpen(!mobileOpen);

    const handleScroll = (id: string) => {
        const element = document.getElementById(id.toLowerCase());
        if (element) {
            const yOffset = -64;
            const y =
                element.getBoundingClientRect().top +
                window.scrollY +
                yOffset;
            window.scrollTo({ top: y, behavior: "smooth" });
            setActiveSection(id);
        }
    };

    const drawer = (
        <Box
            sx={{
                width: 250,
                bgcolor: "background.paper",
                height: "100%",
                display: "flex",
                flexDirection: "column",
                justifyContent: "space-between",
            }}
            role="presentation"
        >
            <List>
                {sections.map((sec) => (
                    <ListItem
                        key={sec}
                        onClick={() => {
                            handleScroll(sec);
                            setMobileOpen(false);
                        }}
                        sx={{ cursor: "pointer" }}
                    >
                        <ListItemText
                            primary={sec}
                            primaryTypographyProps={{
                                sx: {
                                    fontWeight:
                                        activeSection === sec ? 700 : 500,
                                    color:
                                        activeSection === sec
                                            ? "primary.main"
                                            : "text.primary",
                                },
                            }}
                        />
                    </ListItem>
                ))}
            </List>
        </Box>
    );

    return (
        <>
            <AppBar
                position="fixed"
                sx={{
                    backgroundColor: "background.paper",
                    boxShadow: "none",
                    borderBottom: "1px solid rgba(255,255,255,0.05)",
                }}
            >
                <Toolbar sx={{ justifyContent: "space-between" }}>
                    {/* Logo */}
                    <Typography
                        variant="h6"
                        sx={{
                            color: "primary.main",
                            fontWeight: 700,
                            cursor: "pointer",
                        }}
                        onClick={() => handleScroll("home")}
                    >
                        VIJAY KUMAR DVK
                    </Typography>

                    {/* Desktop menu */}
                    <Box
                        sx={{
                            display: { xs: "none", md: "flex" },
                            gap: 3,
                            alignItems: "center",
                        }}
                    >
                        {sections.map((sec) => (
                            <Button
                                key={sec}
                                onClick={() => handleScroll(sec)}
                                sx={{
                                    position: "relative",
                                    color:
                                        activeSection === sec
                                            ? "primary.main"
                                            : "text.primary",
                                    textTransform: "none",
                                    fontWeight:
                                        activeSection === sec ? 700 : 500,
                                    "&:hover": {
                                        color: "primary.main",
                                    },
                                    "&::after": {
                                        content: '""',
                                        position: "absolute",
                                        left: 0,
                                        bottom: -4,
                                        width: "100%",
                                        height: "2px",
                                        backgroundColor: "primary.main",
                                        transform:
                                            activeSection === sec
                                                ? "scaleX(1)"
                                                : "scaleX(0)",
                                        transformOrigin: "left",
                                        transition:
                                            "transform 0.3s ease-in-out",
                                    },
                                }}
                            >
                                {sec}
                            </Button>
                        ))}
                    </Box>

                    {/* Mobile menu button */}
                    <IconButton
                        color="inherit"
                        edge="end"
                        sx={{ display: { md: "none" } }}
                        onClick={handleDrawerToggle}
                    >
                        <MenuIcon />
                    </IconButton>
                </Toolbar>
            </AppBar>

            {/* Mobile Drawer */}
            <Drawer
                anchor="right"
                open={mobileOpen}
                onClose={handleDrawerToggle}
                PaperProps={{
                    sx: { width: 250, bgcolor: "background.paper" },
                }}
            >
                {drawer}
            </Drawer>
        </>
    );
}
