import React, { useMemo, useState, useEffect } from "react";
import { Box, Typography, Card, CardContent, Chip, CardMedia, Tabs, Tab, Grid, Link, Dialog, IconButton } from "@mui/material";
import SectionTitle from "../utils/SectionTitle";
import { useMain } from "../contexts/MainContext";
import OpenInNewIcon from "@mui/icons-material/OpenInNew";
import CloseIcon from "@mui/icons-material/Close";

interface Certification {
    id: number;
    title: string;
    organization: string;
    year: string;
    category: string;
    image: string;
    credentials?: string | null;
    description?: string | null;
}

const tabStyles = {
    bgcolor: "#101820",
    mx: "auto",
    width: "fit-content",
    borderRadius: 1,
    mb: 6,
    "& .MuiTab-root": {
        color: "#d1d5db",
        textTransform: "none",
        fontWeight: 600,
        minWidth: 80,
        zIndex: 0,
        "&.Mui-selected": {
            color: "#0a111e",
            fontWeight: "bold",
            zIndex: 2,
        },
    },
};

const Certifications: React.FC = () => {
    const [filterCategory, setFilterCategory] = useState<string>("All");
    const [certifications, setCertifications] = useState<Certification[]>([]);
    const [lightboxOpen, setLightboxOpen] = useState(false);
    const [lightboxImage, setLightboxImage] = useState<string | null>(null);

    const { mainData } = useMain();

    // Move data extraction to useEffect to ensure consistent hook calls
    useEffect(() => {
        if (mainData && mainData.data && mainData.data.certifications) {
            setCertifications(mainData.data.certifications);
        }
    }, [mainData]);

    const categories = useMemo(() => {
        if (!certifications.length) return ["All"];
        const cats = certifications.map((c) => c.category || "Uncategorized");
        const unique = Array.from(new Set(cats));
        return ["All", ...unique];
    }, [certifications]);

    const filteredCerts = useMemo(() => {
        if (filterCategory === "All") {
            return certifications;
        }
        return certifications.filter((c) => c.category === filterCategory);
    }, [certifications, filterCategory]);

    // Handle loading state
    if (!mainData) {
        return (
            <Box sx={{ py: 6, px: { xs: 2, md: 8 } }} id="certifications">
                <SectionTitle title="Certifications" />
                <Typography>Loading...</Typography>
            </Box>
        );
    }

    return (
        <Box sx={{ py: 6, px: { xs: 2, md: 8 } }}>
            <SectionTitle title="Certifications & Awards" />

            <Tabs
                value={filterCategory}
                onChange={(_, val) => setFilterCategory(val)}
                centered
                slotProps={{
                    indicator: {
                        sx: {
                            bgcolor: "primary.main",
                            height: 36,
                            borderRadius: 1,
                            top: 6,
                            zIndex: 1,
                        },
                    },
                }}
                sx={tabStyles}
            >
                {categories.map((cat) => (
                    <Tab key={cat} label={cat} value={cat} />
                ))}
            </Tabs>

            <Grid container spacing={3} maxWidth={1200} sx={{ mx: "auto" }}>
                {filteredCerts.length > 0 ? (
                    filteredCerts.map((cert) => (
                        <Grid size={{ xs: 12, sm: 6, md: 4 }} key={cert.id}>
                            <Card
                                sx={{
                                    height: "100%",
                                    borderRadius: 3,
                                    backgroundColor: "background.default",
                                    boxShadow: 3,
                                    transition: "transform 0.3s",
                                    "&:hover": { transform: "translateY(-6px)", boxShadow: 6 },
                                    display: "flex",
                                    flexDirection: "column",
                                }}
                            >
                                {cert.image && (
                                    <CardMedia
                                        component="img"
                                        image={cert.image}
                                        alt={cert.title}
                                        sx={{
                                            height: 300,
                                            objectPosition: "top",
                                            borderBottom: "1px solid",
                                            borderColor: "divider",
                                            cursor: "pointer",
                                        }}
                                        onClick={() => {
                                            setLightboxImage(cert.image);
                                            setLightboxOpen(true);
                                        }}
                                    />
                                )}
                                <CardContent sx={{ flexGrow: 1 }}>
                                    <Typography variant="h6" fontWeight="bold" sx={{ fontSize: '1rem' }}>
                                        {cert.title}
                                    </Typography>
                                    <Typography
                                        variant="body2"
                                        color="text.secondary"
                                        gutterBottom
                                    >
                                        {cert.organization} — {cert.year}
                                    </Typography>
                                    {cert.description && (
                                        <Typography
                                            variant="body2"
                                            sx={{ mb: 2, color: "text.primary", whiteSpace: "pre-line", textAlign: "justify", fontSize: '0.8rem' }}
                                        >
                                            {cert.description}
                                        </Typography>
                                    )}
                                    <Chip
                                        label={cert.category}
                                        size="small"
                                        color="primary"
                                        variant="outlined"
                                    />
                                </CardContent>

                                {cert.credentials && (
                                    <Box sx={{ p: 2, pt: 0 }}>
                                        <Link
                                            href={cert.credentials}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            sx={{
                                                display: "flex",
                                                alignItems: "center",
                                                color: "primary.main",
                                                textDecoration: "none",
                                                fontWeight: 600,
                                            }}
                                        >
                                            View Certificate <OpenInNewIcon sx={{ fontSize: 16, ml: 0.5 }} />
                                        </Link>
                                    </Box>
                                )}
                            </Card>
                        </Grid>
                    ))
                ) : (
                    <Grid size={{ xs: 12 }}>
                        <Typography align="center" sx={{ py: 4 }}>
                            No certifications found.
                        </Typography>
                    </Grid>
                )}
            </Grid>

            {/* Lightbox Dialog */}
            <Dialog open={lightboxOpen} onClose={() => setLightboxOpen(false)} maxWidth="md">
                <Box sx={{ position: "relative", bgcolor: "black" }}>
                    <IconButton
                        onClick={() => setLightboxOpen(false)}
                        sx={{ position: "absolute", top: 8, right: 8, color: "white" }}
                    >
                        <CloseIcon />
                    </IconButton>
                    {lightboxImage && (
                        <img
                            src={lightboxImage}
                            alt="Certification"
                            style={{ maxWidth: "100%", maxHeight: "90vh", display: "block", margin: "auto" }}
                        />
                    )}
                </Box>
            </Dialog>
        </Box>
    );
};

export default Certifications;