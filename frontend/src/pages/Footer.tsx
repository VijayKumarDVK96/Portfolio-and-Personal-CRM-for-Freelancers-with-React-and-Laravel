import { Box, Container, Grid, Typography, Stack } from "@mui/material";
import { GitHub, LinkedIn, Email } from "@mui/icons-material";
import IconButtonHelper from "../utils/IconButtonHelper";

const Branding = () => (
    <>
        <Typography
            variant="h6"
            sx={{ color: "primary.main", fontWeight: "bold" }}
        >
            VIJAY KUMAR DVK
        </Typography>
        <Typography variant="body2" sx={{ mt: 1 }}>
            © {new Date().getFullYear()} Vijayakumar D. All rights reserved.
        </Typography>
    </>
);

const socialLinks = [
    { title: "GitHub", icon: <GitHub />, url: "https://github.com" },
    { title: "LinkedIn", icon: <LinkedIn />, url: "https://linkedin.com" },
    { title: "Email", icon: <Email />, url: "mailto:dipak@example.com" },
];

const SocialLinks = () => (
    <Stack
        direction="row"
        justifyContent={{ xs: "center", md: "flex-end" }}
        spacing={2}
    >
        {socialLinks.map((item, idx) => (
            <a
                key={idx}
                href={item.url}
                target={item.url.startsWith("http") ? "_blank" : undefined}
                rel="noopener noreferrer"
                style={{ color: "inherit", textDecoration: "none" }}
            >
                <IconButtonHelper title={item.title} icon={item.icon} />
            </a>
        ))}
    </Stack>
);

export default function Footer() {
    return (
        <Box
            component="footer"
            sx={{
                bgcolor: "#0a0f1a",
                color: "#d1d5db",
                py: 4,
                borderTop: "1px solid rgba(255,255,255,0.1)",
            }}
        >
            <Container maxWidth="lg">
                <Grid
                    container
                    spacing={4}
                    justifyContent="space-between"
                    alignItems="center"
                >
                    <Grid size={{ xs: 12, md: 6 }}>
                        <Branding />
                    </Grid>
                    
                    <Grid size={{ xs: 12, md: 6 }}>
                        <SocialLinks />
                    </Grid>
                </Grid>
            </Container>
        </Box>
    );
}