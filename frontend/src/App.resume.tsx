import React from 'react';
import { ThemeProvider } from '@mui/material/styles';
import { CssBaseline } from '@mui/material';
import Resume from './pages/Resume';
import { MainProvider } from './contexts/MainContext';
import theme from './theme';

// Mock data for preview
const mockMainData = {
    status: 'success',
    data: {
        details: {},
        resume: {
            education: [
                {
                    start: '2018',
                    end: '2022',
                    title: 'Bachelor of Computer Science',
                    company: 'University of Technology',
                    description: 'Focused on software engineering, algorithms, and data structures. Graduated with honors and participated in various coding competitions.',
                    image: 'https://via.placeholder.com/70x70?text=UNI'
                },
                {
                    start: '2016',
                    end: '2018',
                    title: 'Higher Secondary Education',
                    company: 'Central High School',
                    description: 'Specialized in Mathematics and Computer Science. Active member of the programming club.',
                    image: 'https://via.placeholder.com/70x70?text=HS'
                }
            ],
            experience: [
                {
                    start: '2022',
                    end: 'Present',
                    title: 'Senior Frontend Developer',
                    company: 'Tech Solutions Inc.',
                    description: 'Leading frontend development team, architecting scalable React applications, and mentoring junior developers. Implemented modern UI/UX designs and improved application performance by 40%.',
                    image: 'https://via.placeholder.com/70x70?text=TSI'
                },
                {
                    start: '2021',
                    end: '2022',
                    title: 'Frontend Developer Intern',
                    company: 'StartupXYZ',
                    description: 'Developed responsive web applications using React and TypeScript. Collaborated with design team to implement pixel-perfect UI components.',
                    image: 'https://via.placeholder.com/70x70?text=XYZ'
                }
            ]
        },
        skills: [],
        projects: [],
        certifications: []
    }
};

// Mock context provider for preview
const MockMainProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
    const contextValue = {
        mainData: mockMainData,
        loading: false,
        error: null,
        refetch: async () => {}
    };

    return (
        <div>
            {React.cloneElement(children as React.ReactElement, {
                ...contextValue
            })}
        </div>
    );
};

// Override useMain hook for preview
const useMainMock = () => ({
    mainData: mockMainData,
    loading: false,
    error: null,
    refetch: async () => {}
});

// Replace the useMain import in Resume component
const ResumeWithMockData = () => {
    const originalUseMain = require('./contexts/MainContext').useMain;
    
    // Temporarily override useMain
    require('./contexts/MainContext').useMain = useMainMock;
    
    return <Resume />;
};

const AppResume: React.FC = () => {
    return (
        <ThemeProvider theme={theme}>
            <CssBaseline />
            <MainProvider>
                <ResumeWithMockData />
            </MainProvider>
        </ThemeProvider>
    );
};

export default AppResume;