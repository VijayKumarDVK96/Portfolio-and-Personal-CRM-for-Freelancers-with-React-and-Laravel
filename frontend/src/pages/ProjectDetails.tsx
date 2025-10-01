import { useState, useRef, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";

import { Box, Button, Chip, Container, Typography, Grid, Stack, Link } from "@mui/material";

import ArrowBackIosIcon from "@mui/icons-material/ArrowBackIos";
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
import ApiHelper from "../utils/ApiHelper";

// Types
interface GalleryItem {
    id: number;
    image: string;
    position: number;
}


interface ProjectDetails {
  id: number;
  name: string;
  description: string;
  image: string;
  category_id: number;
  category: string;
  project_url: string | null;
  demo_url: string | null;
  created_at: string;
  technologies: string[];
  galleries: GalleryItem[];
}

const ImageSlider = ({
    images,
    onImageClick,
}: {
    images: GalleryItem[];
    onImageClick: (i: number) => void;
}) => {
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
                        <Box key={img.id} sx={{ px: 1 }}>
                            <Box
                                component="img"
                                src={img.image}
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

            <Box
                sx={{
                    display: "flex",
                    justifyContent: "center",
                    gap: 2,
                    mb: 5,
                    flexWrap: "wrap",
                }}
            >
                {images.map((thumb, i) => (
                    <Box
                        key={thumb.id}
                        component="img"
                        src={thumb.image}
                        alt={`Thumbnail ${i + 1}`}
                        onClick={() => sliderRef.current?.slickGoTo(i)}
                        sx={{
                            width: 100,
                            height: 70,
                            objectFit: "cover",
                            cursor: "pointer",
                            borderRadius: 1,
                            border:
                                currentIndex === i
                                    ? "2px solid #5c8700"
                                    : "2px solid transparent",
                            transition: "0.3s",
                        }}
                    />
                ))}
            </Box>
        </>
    );
};

export default function ProjectDetails() {
    const { id } = useParams();
    const navigate = useNavigate();
    const [lightboxOpen, setLightboxOpen] = useState(false);
    const [currentIndex, setCurrentIndex] = useState(0);
    const [projectDetails, setProjectDetails] = useState<ProjectDetails | null>(null);
    const [loading, setLoading] = useState<boolean>(true);
    const [galleries, setGalleries] = useState<GalleryItem[]>([]);

    useEffect(() => {
        if(loading) {
            const fetchProjectDetails = async () => {
                try {
                    const res = await ApiHelper<ProjectDetails>(`project-details/${id}`, "get");

                    setProjectDetails(res.data);

                    const mergedGalleries: GalleryItem[] = [
                        { id: 0, image: res.data.image, position: 0 },
                        ...(res.data.galleries || []),
                    ];

                    setGalleries(mergedGalleries);
                } finally {
                    setLoading(false);
                }
            };

            if (id) fetchProjectDetails();
        }
    }, [id]);

    if (!projectDetails) {
        return (
            <Container>
                <Typography variant="h5" mt={5}>
                    {loading ? "Loading..." : "Project not found"}
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

                <ImageSlider
                    images={galleries}
                    onImageClick={(i) => {
                        setCurrentIndex(i);
                        setLightboxOpen(true);
                    }}
                />

                <Lightbox
                    open={lightboxOpen}
                    close={() => setLightboxOpen(false)}
                    index={currentIndex}
                    slides={galleries.map((g) => ({ src: g.image }))}
                    plugins={[Fullscreen, Zoom, Thumbnails]}
                    carousel={{ finite: true }}
                    thumbnails={{ position: "bottom" }}
                    on={{ view: ({ index }) => setCurrentIndex(index) }}
                />

                <Grid container spacing={2} justifyContent="space-between">
                    <Grid size={{ xs: 12, md: 4 }}>
                        <Chip
                            label={projectDetails.category}
                            size="small"
                            sx={{
                                mb: 1,
                                bgcolor: "#5c8700",
                                color: "white",
                                fontWeight: "bold",
                            }}
                        />

                        <Typography variant="h4" fontWeight="bold" gutterBottom>
                            {projectDetails.name}
                        </Typography>

                        <Stack mt={3} mb={3} direction="row" spacing={3}>
                            {(projectDetails.project_url && projectDetails.project_url !== '#') && (
                                <Link href={projectDetails.project_url} target="_blank" rel="noopener" sx={{ color: "primary.main" }}>
                                    <ButtonHelper
                                        text="Code"
                                        variant="outlined"
                                        icon={<CodeIcon />}
                                    />
                                </Link>
                            )}

                            {(projectDetails.demo_url && projectDetails.demo_url !== '#') && (
                                <Link href={projectDetails.demo_url} target="_blank" rel="noopener" sx={{ color: "primary.main" }}>
                                    <ButtonHelper text="Demo" />
                                </Link>
                            )}
                        </Stack>

                        <Box mt={3} mb={3}>
                            <Typography variant="h6" fontWeight="bold" mb={1}>
                                Technologies Used
                            </Typography>
                            <Box
                                sx={{
                                    display: "flex",
                                    gap: 1,
                                    flexWrap: "wrap",
                                }}
                            >
                                {projectDetails.technologies.map((tag: string) => (
                                    <Chip
                                        key={tag}
                                        label={tag}
                                        size="small"
                                        sx={{
                                            bgcolor: "#5c8700",
                                            color: "white",
                                            fontWeight: "bold",
                                        }}
                                    />
                                ))}
                            </Box>
                        </Box>
                    </Grid>

                    <Grid size={{ xs: 12, md: 8 }}>
                        <Typography variant="h6" fontWeight="bold" mb={1}>Project Description</Typography>

                        {/* Render HTML safely */}
                        <Typography
                            variant="body1"
                            color="grey.100"
                            gutterBottom
                            dangerouslySetInnerHTML={{
                                __html: projectDetails.description,
                            }}
                        />
                    </Grid>
                </Grid>
            </Container>
        </Box>
    );
}