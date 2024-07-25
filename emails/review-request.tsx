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
import {emailTailwindConf} from "./config";

interface ReviewRequestEmailProps {
  companyName: string;
  companyAddress: string;
  companyLogo: string;
  reviewUrl: string;
  unsubscribeUrl: string;
}

export const ReviewRequestEmail = (
  {
    companyName,
    companyAddress,
    companyLogo,
    reviewUrl,
    unsubscribeUrl
  }: ReviewRequestEmailProps
) => {
  return (
    <Html>
      <Head />
      <Tailwind config={emailTailwindConf}>
        <Body className="bg-white mx-auto font-sans px-2">
          <Container className="mt-[40px]">
            <Section className="border border-solid border-[#eaeaea] rounded-lg p-[20px] max-w-[465px]">
              <Img
                src={companyLogo}
                width="100px"
                className="mx-auto mt-[20px] mb-[40px]"
              />

              <Text className="text-black">
                Thanks for visiting us! We&rsquo;d love to know how we&rsquo;re doing.
              </Text>

              <Text className="text-black font-bold">
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

              <Text className="mb-0">
                We hope to see you again soon!
              </Text>
              <Text className="mt-0">
                <strong>{companyName}</strong>
              </Text>
            </Section>

            <Section className="mt-[10px] text-center text-[#bbbbbb]">
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

ReviewRequestEmail.PreviewProps = {
  companyName: "CHIC Circular Fashion",
  companyAddress: "12529 102 Ave NW, Edmonton, AB T5N 0M4",
  companyLogo: "https://recallcx.com/circularchic.png",
  reviewUrl: "https://g.page/r/CRMi-N-HNuIEEBM/review",
  unsubscribeUrl: "http://circularchic.localhost:3000/unsubscribe?email=ZGltaXRyaUByZWNhbGxjeC5jb20="
} as ReviewRequestEmailProps;

export default ReviewRequestEmail;
