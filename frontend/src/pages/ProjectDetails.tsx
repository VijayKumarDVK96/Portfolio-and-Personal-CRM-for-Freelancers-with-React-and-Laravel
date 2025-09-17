import { useState, useRef } from "react";
import { useParams, useNavigate } from "react-router-dom";

import { Box, Button, Chip, Container, Typography, Paper, Grid, Stack, List, ListItem, ListItemIcon, ListItemText } from "@mui/material";

import ArrowBackIosIcon from "@mui/icons-material/ArrowBackIos";
import CheckCircleIcon from "@mui/icons-material/CheckCircle";
import { Code as CodeIcon } from "@mui/icons-material";

import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

import Lightbox from "yet-another-react-lightbox";
import Fullscreen from "yet-another-react-lightbox/plugins/fullscreen";
import Zoom from "yet-another-react-lightbox/plugins/zoom";
import Thumbnails from "yet-another-react-lightbox/plugins/thumbnails";
import "yet-another-react-lightbox/styles.css";
import "yet-another-react-lightbox/plugins/thumbnails.css";

import ButtonHelper from "../utils/ButtonHelper";

interface ProjectData {
    id: number;
    category: string;
    title: string;
    description: string;
    tags: string[];
    duration: string;
    team: string;
    challenges: string;
    solutions: string;
    images: string[];
    codeUrl: string;
    demoUrl: string;
}

const randomSig = () => Math.floor(Math.random() * 1000);

const projectsDetailsData: Record<number, ProjectData> = {
    1: {
        id: 1,
        category: "Full Stack",
        title: "E-Commerce Platform",
        description: "Full-stack e-commerce solution with React, Node.js, and Stripe integration",
        tags: ["React", "Node.js", "MongoDB", "Stripe"],
        duration: "5 months",
        team: "2 developers",
        challenges: "Processing and visualizing large datasets while maintaining performance",
        solutions: "Implemented data virtualization and lazy loading techniques for optimal performance",
        images: [
            "https://www.vijaykumardvk.com/images/projects/thumbnail/64b4c884d542a.png",
            "https://www.vijaykumardvk.com/images/projects/thumbnail/65f80cec0e557.png",
        ],
        codeUrl: "#",
        demoUrl: "#",
    },
    2: {
        id: 2,
        category: "Frontend",
        title: "Task Management App",
        description: "Modern task management application with real-time collaboration",
        tags: ["Vue.js", "TypeScript", "Socket.io"],
        duration: "3 months",
        team: "3 developers",
        challenges: "Maintaining sync across clients in real-time",
        solutions: "Used Socket.io to enable bi-directional real-time communication",
        images: [
            `https://source.unsplash.com/random/900x400/?teamwork,collaboration&sig=${randomSig()}`,
            `https://source.unsplash.com/random/900x400/?productivity,task-management&sig=${randomSig()}`,
        ],
        codeUrl: "#",
        demoUrl: "#",
    },
};

const ImageSlider = ({ images, onImageClick }: { images: string[]; onImageClick: (i: number) => void }) => {
    const sliderRef = useRef<Slider | null>(null);
    const [currentIndex, setCurrentIndex] = useState(0);

    const settings = {
        dots: false,
        infinite: true,
        speed: 400,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        beforeChange: (_: number, next: number) => setCurrentIndex(next),
    };

    return (
        <>
            <Box sx={{ mb: 2 }}>
                <Slider ref={sliderRef} {...settings}>
                    {images.map((img, i) => (
                        <Box key={i} sx={{ px: 1 }}>
                            <Box
                                component="img"
                                src={img}
                                alt={`Slide ${i + 1}`}
                                onClick={() => onImageClick(i)}
                                sx={{
                                    borderRadius: 2,
                                    width: "100%",
                                    height: 500,
                                    objectFit: "cover",
                                    cursor: "pointer",
                                }}
                            />
                        </Box>
                    ))}
                </Slider>
            </Box>
            
            <Box sx={{ display: "flex", justifyContent: "center", gap: 2, mb: 5, flexWrap: "wrap" }}>
                {images.map((thumb, i) => (
                    <Box
                        key={i}
                        component="img"
                        src={thumb}
                        alt={`Thumbnail ${i + 1}`}
                        onClick={() => sliderRef.current?.slickGoTo(i)}
                        sx={{
                            width: 100,
                            height: 70,
                            objectFit: "cover",
                            cursor: "pointer",
                            borderRadius: 1,
                            border: currentIndex === i ? "2px solid primary.main" : "2px solid transparent",
                            transition: "0.3s",
                        }}
                    />
                ))}
            </Box>
        </>
    );
};

const FeaturesList = ({ features }: { features: string[] }) => (
    <List sx={{ p: 0, m: 0 }}>
        {features.map((feature) => (
            <ListItem key={feature} sx={{ p: 0, mb: 1 }}>
                <ListItemIcon sx={{ minWidth: 32, color: "primary.main" }}>
                    <CheckCircleIcon fontSize="small" />
                </ListItemIcon>
                <ListItemText primary={feature} />
            </ListItem>
        ))}
    </List>
);

const ChallengesCard = ({ text }: { text: string }) => (
    <Paper sx={{ p: 2, bgcolor: "#121f05", mb: 2 }}>
        <Typography variant="subtitle1" fontWeight="bold" gutterBottom>
            Challenges
        </Typography>
        <Typography>{text}</Typography>
    </Paper>
);

export default function ProjectDetails() {
    const { id } = useParams();
    const navigate = useNavigate();
    const [lightboxOpen, setLightboxOpen] = useState(false);
    const [currentIndex, setCurrentIndex] = useState(0);

    const data = id ? projectsDetailsData[Number(id)] : undefined;

    if (!data) {
        return (
            <Container>
                <Typography variant="h5" mt={5}>
                    Project not found
                </Typography>
                <Button onClick={() => navigate("/")}>Back to Portfolio</Button>
            </Container>
        );
    }

    return (
        <Box sx={{ bgcolor: "#0b121a", color: "primary.main" }}>
            <Container sx={{ py: 4 }}>
                {/* Back Button */}
                <Button
                    startIcon={<ArrowBackIosIcon />}
                    onClick={() => navigate("/")}
                    sx={{ color: "primary.main", textTransform: "none", mb: 2 }}
                >
                    Back to Portfolio
                </Button>
                
                <ImageSlider images={data.images} onImageClick={(i) => { setCurrentIndex(i); setLightboxOpen(true); }} />
                    
                <Lightbox
                    open={lightboxOpen}
                    close={() => setLightboxOpen(false)}
                    index={currentIndex}
                    slides={data.images.map((src) => ({ src }))}
                    plugins={[Fullscreen, Zoom, Thumbnails]}
                    carousel={{ finite: true }}
                    thumbnails={{ position: "bottom" }}
                    on={{ view: ({ index }) => setCurrentIndex(index) }}
                />
                
                <Grid container spacing={2} justifyContent="space-between">
                    <Grid size={{ xs: 12, md: 4 }}>
                        <Chip label={data.category} size="small" sx={{ mb: 1, bgcolor: "#5c8700", color: "white", fontWeight: "bold" }} />

                        <Typography variant="h4" fontWeight="bold" gutterBottom>
                            {data.title}
                        </Typography>

                        <Typography variant="body1" color="grey.100" gutterBottom>
                            {data.description}
                        </Typography>
                        
                        <Stack mt={3} mb={3} direction="row" spacing={3}>
                            <ButtonHelper text="Code" variant="outlined" icon={<CodeIcon />} />
                            <ButtonHelper text="Demo" />
                        </Stack>
                        
                        <Box mt={3} mb={3}>
                            <Typography variant="h6" fontWeight="bold" mb={1}>
                                Technologies Used
                            </Typography>
                            <Box sx={{ display: "flex", gap: 1, flexWrap: "wrap" }}>
                                {data.tags.map((tag) => (
                                    <Chip key={tag} label={tag} size="small" sx={{ bgcolor: "#5c8700", color: "white", fontWeight: "bold" }} />
                                ))}
                            </Box>
                        </Box>
                        
                        <Typography variant="h6" fontWeight="bold" gutterBottom>
                            Key Features
                        </Typography>
                        <FeaturesList
                            features={[
                                "Interactive charts and graphs",
                                "Real-time data updates",
                                "Custom report generation",
                                "Data export functionality",
                                "Responsive design",
                                "Advanced filtering options",
                            ]}
                        />
                    </Grid>
                    
                    <Grid size={{ xs: 12, md: 8 }}>
                        <ChallengesCard text={data.challenges} />
                    </Grid>
                </Grid>
            </Container>
        </Box>
    );
}