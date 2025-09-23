import type { ReactNode } from 'react';
import { IconButton, Tooltip } from '@mui/material';

type IconButtonHelperProps = {
  title: string;
  icon: ReactNode;
  url?: string;
}

const IconButtonHelper: React.FC<IconButtonHelperProps> = ({ title, icon, url }) => {
  const handleClick = () => {
    if (url) {
      if (url.startsWith('http') || url.startsWith('mailto:')) {
        window.open(url, '_blank', 'noopener,noreferrer');
      } else {
        window.location.href = url;
      }
    }
  };

  return (
    <Tooltip title={title} aria-label={`${title.toLowerCase()}-button-helper`}>
      <IconButton
        size="small"
        aria-label={`${title.toLowerCase()}-button`}
        onClick={handleClick}
      >
        {icon}
      </IconButton>
    </Tooltip>
  );
}

export default IconButtonHelper;