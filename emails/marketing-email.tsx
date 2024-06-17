import {
  Body,
  Container,
  Head,
  Html,
  Link,
  Button,
  Text,
  Tailwind, Section, Img,
} from "@react-email/components";
import * as React from "react";
import { emailTailwindConf } from "./config";

interface MarketingEmailProps {
  companyName: string;
  unsubscribeUrl: string;
}

export const MarketingEmail = ({
  companyName,
  unsubscribeUrl
}: MarketingEmailProps) => {
  return (
    <Html>
      <Head/>
      <Tailwind config={emailTailwindConf}>
        <Body className="bg-white my-auto mx-auto font-sans px-2">
          <Container
            className="border border-solid border-[#eaeaea] rounded-lg mt-[40px] mx-auto p-[20px] max-w-[465px]">

            <Img
              src="https://recallcx.com/circularchic.png"
              width="100px"
              className="mx-auto mt-[20px] mb-[40px]"
            />


            <Text className="text-black text-[14px] leading-[24px] font-bold">
              Our Spring sale starts NOW!
            </Text>

            <Text>
              Come visit us in The High Street at 12529 102 Ave NW between June 10-24 to get up to 50% off your purchase.
            </Text>

            <Text className="text-black text-[14px] leading-[24px] font-bold">
              Check out our Instagram for the latest spring drops 👇
            </Text>

            <Section className="text-center mt-[32px] mb-[32px]">
              <Button
                className="bg-[#000000] rounded text-white text-[12px] font-semibold no-underline text-center px-5 py-3"
              >
                View our Instagram
              </Button>
            </Section>

            <Text className="text-black text-[14px] leading-[24px]">
              We hope to see you soon!
            </Text>
          </Container>
          <Container className="mt-[10px] text-center text-[#bbbbbb] ">
            <Text className="leading-none mb-0 text-[12px]">
              {companyName}
            </Text>
            <Text className="leading-none mt-[2px] text-[12px]">
              12529 102 Ave NW, Edmonton, AB T5N 0M4
            </Text>
            <Text className="leading-none mt-0 text-[12px]">
              If you would like to stop receiving emails, you
              can <Link href={unsubscribeUrl} className="text-[#bbbbbb] underline">unsubscribe</Link>.
            </Text>
          </Container>
        </Body>
      </Tailwind>
    </Html>
  );
};

MarketingEmail.PreviewProps = {
  companyName: "CHIC Circular Fashion",
  unsubscribeUrl: "http://circularchic.localhost:3000/unsubscribe?email=ZGltaXRyaUByZWNhbGxjeC5jb20="
} as MarketingEmailProps;

export default MarketingEmail;
