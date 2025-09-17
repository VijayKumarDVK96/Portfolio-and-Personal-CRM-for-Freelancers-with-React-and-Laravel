import { Box, Container, Grid, Typography, TextField, Paper, Stack } from "@mui/material";
import EmailIcon from "@mui/icons-material/Email";
import PhoneIcon from "@mui/icons-material/Phone";
import LocationOnIcon from "@mui/icons-material/LocationOn";
import SendIcon from "@mui/icons-material/Send";
import SectionTitle from "../utils/SectionTitle";
import ButtonHelper from "../utils/ButtonHelper";
import { useEffect, useState } from "react";
import { useMain } from "../contexts/MainContext";

const ContactInfoItem = ({
    icon,
    title,
    value,
}: {
    icon: React.ReactNode;
    title: string;
    value: string;
}) => (
    <Box display="flex" alignItems="center" gap={2}>
        {icon}
        <Box>
            <Typography variant="subtitle2" fontWeight="bold">
                {title}
            </Typography>
            <Typography variant="body2">{value}</Typography>
        </Box>
    </Box>
);

const CustomTextField = ({
    label,
    multiline = false,
    rows,
}: {
    label: string;
    multiline?: boolean;
    rows?: number;
}) => (
    <TextField
        label={label}
        multiline={multiline}
        rows={rows}
        fullWidth
        variant="outlined"
        slotProps={{
            inputLabel: {
                sx: { color: "primary.main" }
            }
        }}
        sx={{
            "& .MuiOutlinedInput-root": {
                bgcolor: "#1a1f29",
                color: "#fff",
                borderRadius: 1,
                "& fieldset": { borderColor: "#333" },
                "&:hover fieldset": { borderColor: "primary.main" },
                "&.Mui-focused fieldset": { borderColor: "primary.main" },
            },
        }}
    />
);

export default function Contact() {

    const { mainData } = useMain();
    const [contact, setContact] = useState<any>(null);

    useEffect(() => {
        if (mainData && mainData.data && mainData.data.details) {
            setContact(mainData.data.details);
        }
    }, [mainData]);

    return (
        <Box sx={{ bgcolor: "#101820", color: "#fff", py: 10 }}>
            <Container maxWidth="lg">
                <SectionTitle title="Contact Me" />

                <Grid container spacing={6}>
                    {/* Left Side - Contact Info */}
                    <Grid size={{ xs: 12, md: 5 }}>
                        <Typography variant="h6" sx={{ color: "primary.main", mb: 2 }}>
                            Get In Touch
                        </Typography>
                        <Typography variant="body1" sx={{ mb: 4, color: "#d1d5db" }}>
                            I'm always open to discussing new opportunities, interesting
                            projects, or just having a chat about technology and development.
                        </Typography>

                        <Stack spacing={3}>
                            <ContactInfoItem
                                icon={<EmailIcon sx={{ color: "primary.main" }} />}
                                title="Email"
                                value={contact?.email || ""}
                            />
                            <ContactInfoItem
                                icon={<PhoneIcon sx={{ color: "primary.main" }} />}
                                title="Phone"
                                value={contact?.mobile || ""}
                            />
                            <ContactInfoItem
                                icon={<LocationOnIcon sx={{ color: "primary.main" }} />}
                                title="Location"
                                value={contact?.city+', '+contact?.state || ""}
                            />
                        </Stack>
                    </Grid>

                    {/* Right Side - Contact Form */}
                    <Grid size={{ xs: 12, md: 7 }}>
                        <Paper
                            sx={{
                                bgcolor: "#0a111e",
                                p: 4,
                                borderRadius: 2,
                            }}
                            elevation={0}
                        >
                            <Grid container spacing={3}>
                                <Grid size={{ xs: 12, md: 6 }}>
                                    <CustomTextField label="Name" />
                                </Grid>
                                <Grid size={{ xs: 12, md: 6 }}>
                                    <CustomTextField label="Email" />
                                </Grid>
                                <Grid size={{ xs: 12 }}>
                                    <CustomTextField label="Subject" />
                                </Grid>
                                <Grid size={{ xs: 12 }}>
                                    <CustomTextField label="Message" multiline rows={5} />
                                </Grid>
                                <Grid size={{ xs: 12 }}>
                                    <ButtonHelper text="Send Message" icon={<SendIcon />} />
                                </Grid>
                            </Grid>
                        </Paper>
                    </Grid>
                </Grid>
            </Container>
        </Box>
    );
}