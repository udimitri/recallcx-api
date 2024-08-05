import {SVGAttributes} from 'react';

export default function ApplicationLogo(props: SVGAttributes<SVGElement>) {
  return (
    <svg  {...props} width="441" height="426" viewBox="0 0 441 426" fill="none" xmlns="http://www.w3.org/2000/svg">
      <g clip-path="url(#clip0_32_147)">
        <path
          d="M239.156 0V118.083H322.273V214.384C323.641 237.645 315.713 260.496 300.234 277.911C284.754 295.326 262.99 305.879 239.729 307.247V425.333H332.592H440.362V307.247V0H439.787H332.593H239.156Z"
          fill="#29A4D6" />
        <path
          d="M0 0V118.083V425.333H0.575557H107.769H201.205V307.247H118.088V210.946C116.72 187.685 124.648 164.834 140.128 147.419C155.608 130.004 177.372 119.451 200.632 118.083V0H107.769H0Z"
          fill="#29A4D6" />
      </g>
      <defs>
        <clipPath id="clip0_32_147">
          <rect width="440.361" height="425.333" fill="white" />
        </clipPath>
      </defs>
    </svg>

  );
}
