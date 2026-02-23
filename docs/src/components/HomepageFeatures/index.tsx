import type {ReactNode} from 'react';
import clsx from 'clsx';
import Heading from '@theme/Heading';
import styles from './styles.module.css';

type FeatureItem = {
  title: string;
  description: ReactNode;
};

const FeatureList: FeatureItem[] = [
  {
    title: 'Sign up',
    description: (
      <>
        <a href="https://talk.hyvor.com/console?signup&partner=matdave">Register for Hyvor Talk</a> and enter your website's details in the Console.
      </>
    ),
  },
  {
    title: 'Install',
    description: (
      <>
        Install the Extra and put the included Snippets into your website's Templates.
      </>
    ),
  },
  {
    title: 'Customize & Enjoy',
    description: (
      <>
        Personalize the appearance and text, then enjoy Hyvor Talk on your site.
      </>
    ),
  },
];

function Feature({title, Svg, description}: FeatureItem) {
  return (
    <div className={clsx('col col--4 margin-vert--lg')}>
      <div className="text--center padding-horiz--md">
        <Heading as="h3">{title}</Heading>
        <p>{description}</p>
      </div>
    </div>
  );
}

export default function HomepageFeatures(): ReactNode {
  return (
    <section className={styles.features}>
      <div className="container">
        <div className="row">
          {FeatureList.map((props, idx) => (
            <Feature key={idx} {...props} />
          ))}
        </div>
      </div>
    </section>
  );
}
