import {
  Body,
  Container,
  Head,
  Html,
  Link,
  Text,
  Tailwind,
  Img,
  Section,
} from "@react-email/components";
import * as React from "react";
import {emailTailwindConf} from "./config";

interface MarketingEmailProps {
  companyName: string;
  companyAddress: string;
  companyLogo: string;
  unsubscribeUrl: string;
  message: string;
}

export const MarketingEmail = (
  {
    companyName,
    companyAddress,
    companyLogo,
    message,
    unsubscribeUrl
  }: MarketingEmailProps
) => {
  return (
    <Html>
      <Head />
      <Tailwind config={emailTailwindConf}>
        <Body className="bg-white mx-auto font-sans px-2">
          <Container className="py-[20px] px-[5px]">
            <Section className="mb-[20px]">
              <Img
                src={companyLogo}
                width="100px"
                className="mx-auto"
              />
            </Section>

            <Section className="max-w-[465px] rounded-[2rem] overflow-hidden bg-white px-4">
              <Text className="bg-[#E9E9EB] px-4 py-3 rounded-xl text-sm whitespace-pre-line">
                {message}
              </Text>
            </Section>

            <Section className="text-center text-[#bbbbbb]">
              <Text className="leading-none mb-0 text-xs">
                {companyName}
              </Text>
              <Text className="leading-none mt-[2px] text-xs">
                {companyAddress}
              </Text>
              <Text className="leading-none mt-0 text-xs">
                If you would like to stop receiving emails, you
                can <Link href={unsubscribeUrl} className="text-[#bbbbbb] underline">unsubscribe</Link>.
              </Text>
            </Section>
          </Container>
        </Body>
      </Tailwind>
    </Html>
  );
};

MarketingEmail.PreviewProps = {
  companyName: "CHIC Circular Fashion",
  companyAddress: "12529 102 Ave NW, Edmonton, AB T5N 0M4",
  companyLogo: "https://recallcx.com/circularchic.png",
  message: "Our Spring sale starts NOW! \n\nCome visit us in The High Street at 12529 102 Ave NW between June 10-24 to get up to 50% off your purchase.",
  unsubscribeUrl: "http://circularchic.localhost:3000/unsubscribe?email=ZGltaXRyaUByZWNhbGxjeC5jb20="
} as MarketingEmailProps;

export default MarketingEmail;
