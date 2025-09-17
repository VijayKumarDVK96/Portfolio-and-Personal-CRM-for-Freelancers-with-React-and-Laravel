import { Box, Grid, Typography, Card, CardContent, IconButton } from "@mui/material";
import CodeIcon from "@mui/icons-material/Code";
import StorageIcon from "@mui/icons-material/Storage";
import CloudIcon from "@mui/icons-material/Cloud";
import PublicIcon from "@mui/icons-material/Public";
import SectionTitle from "../utils/SectionTitle";

const specializations = [
    {
        id: "frontend",
        title: "Frontend Development",
        description: "Creating responsive and interactive user interfaces with modern frameworks like React, Vue.js, and Angular.",
        icon: <CodeIcon fontSize="large" sx={{ color: "primary.main" }} />,
    },
    {
        id: "backend",
        title: "Backend Development",
        description: "Building robust server-side applications and APIs using Node.js, Python, and various database technologies.",
        icon: <StorageIcon fontSize="large" sx={{ color: "primary.main" }} />,
    },
    {
        id: "cloud",
        title: "Cloud Computing",
        description: "Deploying and managing applications on cloud platforms like AWS, Azure, and Google Cloud.",
        icon: <CloudIcon fontSize="large" sx={{ color: "primary.main" }} />,
    },
    {
        id: "fullstack",
        title: "Full Stack Solutions",
        description: "End-to-end development from conception to deployment, handling both frontend and backend requirements.",
        icon: <PublicIcon fontSize="large" sx={{ color: "primary.main" }} />,
    },
];

export default function Specializations() {
    return (
        <Box
            id="specializations"
            sx={{
                bgcolor: "#000",
                color: "white",
                py: 8,
                px: { xs: 2, md: 6 },
                textAlign: "center",
            }}
        >
            <SectionTitle title="My Specializations" />

            <Grid container spacing={4} maxWidth={1200} sx={{ mx: "auto" }}>
                {specializations.map((item) => (
                    <Grid size={{ xs: 12, sm: 6, md: 3 }} key={item.id}>
                        <Card
                            sx={{
                                bgcolor: "#1a1d21",
                                color: "white",
                                textAlign: "center",
                                p: 3,
                                borderRadius: "16px",
                                transition: "all 0.3s ease-in-out",
                                height: "300px",
                                "&:hover": {
                                    transform: "translateY(-10px)",
                                    boxShadow: "0 8px 20px rgba(0, 255, 100, 0.3)",
                                },
                            }}
                        >
                            <IconButton
                                sx={{
                                    bgcolor: "#2d382d",
                                    mb: 2,
                                    "&:hover": { bgcolor: "#3f4e3f" },
                                }}
                            >
                                {item.icon}
                            </IconButton>
                            <CardContent>
                                <Typography variant="h6" fontWeight="bold" gutterBottom>
                                    {item.title}
                                </Typography>
                                <Typography variant="body2" color="text.primary">
                                    {item.description}
                                </Typography>
                            </CardContent>
                        </Card>
                    </Grid>
                ))}
            </Grid>
        </Box>
    );
}
