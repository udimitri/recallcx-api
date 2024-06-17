import {
  Body,
  Container,
  Head,
  Html,
  Link,
  Button,
  Text,
  Tailwind,
  Section,
  Img,
} from "@react-email/components";
import * as React from "react";
import { emailTailwindConf } from "./config";

interface ReviewRequestEmailProps {
  companyName: string;
  reviewUrl: string;
  unsubscribeUrl: string;
}

export const ReviewRequestEmail = ({
  companyName,
  reviewUrl,
  unsubscribeUrl
}: ReviewRequestEmailProps) => {
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

            <Text className="text-black text-[14px] leading-[24px]">
              Thanks for visiting us! We&rsquo;d love to know how we&rsquo;re doing.
            </Text>

            <Text className="text-black text-[14px] leading-[24px] font-bold">
              Do you have 60 seconds to leave us a quick review?
            </Text>

            <Section className="text-center mt-[32px] mb-[32px]">
              <Button
                href={reviewUrl}
                className="bg-[#000000] rounded text-white text-[12px] font-semibold no-underline text-center px-5 py-3"
              >
                Leave a review
              </Button>
            </Section>

            <Text className="text-black text-[14px] leading-[24px]">
              We hope to see you again soon!<br/>
              <strong>CHIC Circular Fashion</strong>
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

ReviewRequestEmail.PreviewProps = {
  companyName: "CHIC Circular Fashion",
  reviewUrl: "https://g.page/r/CRMi-N-HNuIEEBM/review",
  unsubscribeUrl: "http://circularchic.localhost:3000/unsubscribe?email=ZGltaXRyaUByZWNhbGxjeC5jb20="
} as ReviewRequestEmailProps;

export default ReviewRequestEmail;
